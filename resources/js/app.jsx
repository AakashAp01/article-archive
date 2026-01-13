import ReactDOM from "react-dom/client";
import React, { useRef, useState, useEffect, useMemo } from 'react';
import { Github, Twitter, Linkedin } from 'lucide-react';

import Card from '../js/src/components/Card';
import Minimap from '../js/src/components/Minimap';
import Header from '../js/src/components/Header'; 

import { useWorldEngine } from '../js/src/hooks/useWorldEngine';
import { useViewportFetcher } from '../js/src/hooks/useViewportFetcher';

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

            {/* --- HEADER (Fixed Position - Independent of Overlay) --- */}
            <Header 
                user={user} 
                handleLogout={handleLogout} 
                mapData={mapData} 
                onNavigate={navigateToCard} 
            />

            {/* Changed justify-between to justify-end so the footer stays at bottom */}
            <div className="fixed inset-0 pointer-events-none z-40 p-4 md:p-8 flex flex-col justify-end">

                {/* --- FOOTER --- */}
                <div className="relative w-full flex items-end justify-between">
                    
                    {/* 1. Left: Socials & Text */}
                    <div className="hidden md:flex items-center gap-6 pointer-events-auto">
                        <div className="text-xs text-[#888] opacity-70 font-[Courier_New] tracking-widest">
                            SCROLL / DRAG TO EXPLORE
                        </div>
                        <div className="w-8 h-[1px] bg-white/10"></div>
                        <div className="flex items-center gap-4 text-[#888]">
                            <Github className="w-5 h-5 hover:text-[#00ff88] cursor-pointer hover:scale-110 transition-all" />
                            <Twitter className="w-5 h-5 hover:text-[#00ff88] cursor-pointer hover:scale-110 transition-all" />
                            <Linkedin className="w-5 h-5 hover:text-[#00ff88] cursor-pointer hover:scale-110 transition-all" />
                        </div>
                    </div>

                    {/* 2. Center: Coordinates */}
                    <div className="absolute left-1/2 -translate-x-1/2 bottom-0 pointer-events-auto">
                        <div className="px-5 py-2 bg-black/80 border border-white/10 rounded-full backdrop-blur-sm flex items-center gap-3 shadow-lg">
                            <div className="text-[10px] font-[Courier_New] text-[#00ff88] tracking-widest font-bold">
                                <span ref={coordRef}>X: 0 | Y: 0</span>
                            </div>
                        </div>
                    </div>

                    {/* 3. Right: Minimap & Instructions */}
                    <div className="flex flex-col items-end gap-4 pointer-events-auto">
                        
                        {/* MINIMAP CONTAINER */}
                        <div className="relative">
                            <Minimap
                                articles={mapData}
                                scaleFactor={SCALE_FACTOR}
                                onNavigate={navigateToCard}
                                onJump={jumpToMinimap}
                                indicatorRef={minimapIndicatorRef}
                                worldLimit={worldLimit}
                            />
                        </div>

                        <div className="hidden md:flex items-center gap-2">
                            <div className="text-[10px] font-[Courier_New] text-[#888] opacity-70 tracking-widest">
                                DOUBLE CLICK MAP TO JUMP
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* WORLD VIEWPORT */}
            <div id="viewport" ref={viewportRef} className="w-full h-full relative overflow-hidden cursor-grab active:cursor-grabbing">
                <div id="world" ref={worldRef} className="absolute top-1/2 left-1/2 w-0 h-0">

                    {/* Grid Background */}
                    <div className="grid-bg absolute -top-[50000px] -left-[50000px] w-[100000px] h-[100000px] opacity-10 pointer-events-none"></div>

                    {/* World Border */}
                    <div className="absolute border-2 border-dashed border-red-500/30 pointer-events-none -z-10"
                        style={{
                            width: `${worldLimit * 2}px`,
                            height: `${worldLimit * 2}px`,
                            top: `-${worldLimit}px`,
                            left: `-${worldLimit}px`
                        }}>
                        <div className="absolute top-0 left-0 bg-red-500/20 text-red-500 text-[10px] px-2 py-1 font-mono">
                            LIMIT: {worldLimit}px
                        </div>
                    </div>

                    {/* Cards */}
                    {visibleArticles.map(art => (
                        <Card
                            key={art.id}
                            data={art}
                            onClick={(data) => {
                                setActiveArticle(data);
                                navigateToCard(data);
                            }}
                            isHighlighted={highlightedId === art.id}
                        />
                    ))}
                </div>
            </div>
        </div>
    );
};

ReactDOM.createRoot(document.getElementById("app")).render(<App />);