import ReactDOM from "react-dom/client";
import React, { useRef, useState, useEffect, useMemo } from 'react';

import Header from './src/components/Header'; 
import Footer from './src/components/Footer';
import WorldViewport from './src/components/WorldViewport';

import { useWorldEngine } from './src/hooks/useWorldEngine';
import { useViewportFetcher } from './src/hooks/useViewportFetcher';

const DEFAULT_LIMIT = 4000;

const App = () => {
    // --- Refs ---
    const worldRef = useRef(null);
    const viewportRef = useRef(null);
    const minimapIndicatorRef = useRef(null);
    const coordRef = useRef(null);

    // --- State ---
    const [activeArticle, setActiveArticle] = useState(null);
    const [highlightedId, setHighlightedId] = useState(null);
    const [mapData, setMapData] = useState([]);
    const [worldLimit, setWorldLimit] = useState(DEFAULT_LIMIT);

    // --- 1. Logic: Calculate Boundary ---
    const dynamicBoundary = useMemo(() => {
        if (mapData.length === 0) return DEFAULT_LIMIT;
        let maxCoord = 0;
        mapData.forEach(item => {
            const absX = Math.abs(item.x);
            const absY = Math.abs(item.y);
            if (absX > maxCoord) maxCoord = absX;
            if (absY > maxCoord) maxCoord = absY;
        });
        return Math.max(DEFAULT_LIMIT, maxCoord + 2000);
    }, [mapData]);

    // --- 2. Physics Engine ---
    const {
        navigateToCard,
        jumpToMinimap,
        SCALE_FACTOR,
        cameraPosition,
        currentScale
    } = useWorldEngine(
        viewportRef,
        worldRef,
        minimapIndicatorRef,
        coordRef,
        activeArticle,
        setActiveArticle,
        setHighlightedId,
        worldLimit
    );

    // --- 3. Data Fetching ---
    useEffect(() => {
        fetch('/canvas/map')
            .then(res => res.json())
            .then(data => setMapData(data))
            .catch(err => console.error("Map Load Error:", err));

        fetch('/canvas/bounds')
            .then(res => res.json())
            .then(data => {
                setWorldLimit(data.limit + 2000);
            })
            .catch(err => console.error("Bounds Load Error:", err));
    }, []);

    // --- 4. Viewport Card Fetching & User Data ---
    const effectiveCamera = cameraPosition || { x: 0, y: 0 };
    const visibleArticles = useViewportFetcher(effectiveCamera, currentScale);
    
    // Auth Logic
    const root = document.getElementById("app");
    const user = root.dataset.user ? JSON.parse(root.dataset.user) : null;
    
    const handleLogout = () => {
        const form = document.getElementById("logout-form");
        if (form) form.submit();
    };

    return (
        <div className="bg-[#0a0a0f] text-[#e0e0e0] overflow-hidden h-screen w-screen relative selection:bg-[#00ff88] selection:text-black">

            {/* --- HEADER --- */}
            <Header 
                user={user} 
                handleLogout={handleLogout} 
                mapData={mapData} 
                onNavigate={(data) => {
                    setActiveArticle(null); // Clear active state when navigating via search
                    navigateToCard(data);
                }} 
            />

            {/* --- FOOTER --- */}
            <Footer 
                coordRef={coordRef}
                mapData={mapData}
                SCALE_FACTOR={SCALE_FACTOR}
                navigateToCard={navigateToCard}
                jumpToMinimap={jumpToMinimap}
                minimapIndicatorRef={minimapIndicatorRef}
                worldLimit={worldLimit}
            />

            {/* WORLD VIEWPORT */}
            <WorldViewport 
                viewportRef={viewportRef}
                worldRef={worldRef}
                worldLimit={worldLimit}
                visibleArticles={visibleArticles}
                highlightedId={highlightedId}
                onCardClick={(data) => {
                    setActiveArticle(data);
                    navigateToCard(data);
                }}
            />
        </div>
    );
};

ReactDOM.createRoot(document.getElementById("app")).render(<App />);