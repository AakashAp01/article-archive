import { useState, useEffect, useRef, useCallback } from 'react';
import debounce from 'lodash/debounce';

const CHUNK_SIZE = 2500; 
const BUFFER = 500;

export const useViewportFetcher = (cameraPosition, scale) => {
    const [visibleArticles, setVisibleArticles] = useState([]);
    const [loadedChunks, setLoadedChunks] = useState(new Set());
    const isFetching = useRef(false);

    const fetchCards = useCallback(async () => {
        // Safety: Don't fetch if camera isn't ready
        if (!cameraPosition || isFetching.current) return;

        // 1. Calculate Bounds
        const centerX = -cameraPosition.x; 
        const centerY = -cameraPosition.y;
        
        // Safety: Ensure scale is valid
        const currentScale = scale || 1; 
        const viewportW = window.innerWidth / currentScale;
        const viewportH = window.innerHeight / currentScale;

        const bounds = {
            minX: centerX - viewportW / 2 - BUFFER,
            maxX: centerX + viewportW / 2 + BUFFER,
            minY: centerY - viewportH / 2 - BUFFER,
            maxY: centerY + viewportH / 2 + BUFFER
        };

        // 2. Grid Logic
        const gridX = Math.round((centerX) / CHUNK_SIZE);
        const gridY = Math.round((centerY) / CHUNK_SIZE);
        const chunkKey = `${gridX}:${gridY}`;

        if (loadedChunks.has(chunkKey)) return; 

        isFetching.current = true;
        console.log(`📡 Fetching Sector ${chunkKey}...`); // Debug Log

        try {
            const query = new URLSearchParams({
                min_x: Math.floor(bounds.minX - CHUNK_SIZE/2),
                max_x: Math.ceil(bounds.maxX + CHUNK_SIZE/2),
                min_y: Math.floor(bounds.minY - CHUNK_SIZE/2),
                max_y: Math.ceil(bounds.maxY + CHUNK_SIZE/2),
            });

            // FIX: Added '/api' prefix
            const response = await fetch(`/canvas/viewport?${query}`);
            
            if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
            
            const newCards = await response.json();

            setVisibleArticles(prev => {
                const existingIds = new Set(prev.map(a => a.id));
                const uniqueNewCards = newCards.filter(c => !existingIds.has(c.id));
                return [...prev, ...uniqueNewCards];
            });

            setLoadedChunks(prev => new Set(prev).add(chunkKey));

        } catch (error) {
            console.error("Viewport Fetch Error:", error);
        } finally {
            isFetching.current = false;
        }
    }, [cameraPosition, scale, loadedChunks]);

    useEffect(() => {
        // If cameraPosition is null (initial load), don't fire
        if (!cameraPosition) return;

        const debouncedFetch = debounce(fetchCards, 300);
        debouncedFetch();
        return () => debouncedFetch.cancel();
    }, [cameraPosition, scale, fetchCards]);

    return visibleArticles;
};