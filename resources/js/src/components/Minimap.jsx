import React, { useState, useRef } from 'react';
import { Maximize2, X } from 'lucide-react';
import ArticleDot from './ArticleDot';
import MinimapIndicator from './MinimapIndicator';

const Minimap = ({ articles, onNavigate, onJump, indicatorRef, worldLimit }) => {
  const [isExpanded, setIsExpanded] = useState(false);
  
  const [transform, setTransform] = useState({ k: 1, x: 0, y: 0 });
  const [isDragging, setIsDragging] = useState(false);
  
  const mapRef = useRef(null);
  const dragStartRef = useRef({ x: 0, y: 0 });
  const lastPanRef = useRef({ x: 0, y: 0 });

  const closeMap = () => {
    setIsExpanded(false);
    setTimeout(() => {
        setTransform({ k: 1, x: 0, y: 0 });
    }, 300);
  };

  const handleDotClick = (e, art) => {
    e.stopPropagation();
    if (!isDragging) {
        onNavigate(art);
        closeMap();
    }
  };

  const handleWheel = (e) => {
    if (!isExpanded) return;
    e.stopPropagation();
    e.preventDefault();

    const rect = mapRef.current.getBoundingClientRect();
    
    const delta = e.deltaY > 0 ? -0.2 : 0.2;
    const newScale = Math.min(Math.max(transform.k + delta, 1), 4);
    
    if (newScale === transform.k) return; 

    const mouseX = e.clientX - rect.left;
    const mouseY = e.clientY - rect.top;

    const worldX = (mouseX - transform.x) / transform.k;
    const worldY = (mouseY - transform.y) / transform.k;

    let newX = mouseX - (worldX * newScale);
    let newY = mouseY - (worldY * newScale);

    const minX = rect.width - (rect.width * newScale);
    const minY = rect.height - (rect.height * newScale);

    newX = Math.min(0, Math.max(newX, minX));
    newY = Math.min(0, Math.max(newY, minY));

    setTransform({ k: newScale, x: newX, y: newY });
  };

  const handleMouseDown = (e) => {
    if (!isExpanded) return;
    
    if (transform.k <= 1) return;

    e.preventDefault();
    e.stopPropagation();
    
    dragStartRef.current = { x: e.clientX, y: e.clientY };
    lastPanRef.current = { x: transform.x, y: transform.y };
    setIsDragging(true);
  };

  const handleMouseMove = (e) => {
    if (!isDragging || !isExpanded) return;
    e.preventDefault();
    e.stopPropagation();

    const dx = e.clientX - dragStartRef.current.x;
    const dy = e.clientY - dragStartRef.current.y;
    
    let newX = lastPanRef.current.x + dx;
    let newY = lastPanRef.current.y + dy;

    const rect = mapRef.current.getBoundingClientRect();
    const minX = rect.width - (rect.width * transform.k);
    const minY = rect.height - (rect.height * transform.k);

    newX = Math.min(0, Math.max(newX, minX));
    newY = Math.min(0, Math.max(newY, minY));

    setTransform(prev => ({ ...prev, x: newX, y: newY }));
  };

  const handleMouseUp = (e) => {
    if (isDragging) {
        setIsDragging(false);
        const dist = Math.hypot(e.clientX - dragStartRef.current.x, e.clientY - dragStartRef.current.y);
        if (dist < 5) {
            onJump(e, mapRef.current.getBoundingClientRect());
        }
    } else if (isExpanded && transform.k === 1) {
       onJump(e, mapRef.current.getBoundingClientRect());
    }
  };

  const handleMouseLeave = () => {
    if (isDragging) setIsDragging(false);
  };

  return (
    <>
      <div
        className={`transition-all duration-300 rounded ease-[cubic-bezier(0.25,0.8,0.25,1)]
          ${isExpanded
            ? "fixed inset-0 z-[200] bg-black/80 backdrop-blur-md flex items-center justify-center pointer-events-auto"
            : "relative pointer-events-auto z-[80] md:flex md:items-end md:justify-end"
          }
        `}
        onClick={(e) => {
          if (isExpanded && e.target === e.currentTarget) closeMap();
        }}
        onMouseDown={(e) => e.stopPropagation()}
      >

        {isExpanded && (
            <button
              onClick={closeMap}
              className="absolute top-8 right-8 z-[220] group bg-black/50 border border-white/10 text-white w-12 h-12 rounded-full cursor-pointer flex items-center justify-center transition-all duration-300 hover:border-[#00ff88] hover:text-[#00ff88] hover:bg-black/80 hover:rotate-90 backdrop-blur-md"
            >
              <X size={24} />
            </button>
        )}

        {!isExpanded && (
            <button
                onClick={() => setIsExpanded(true)}
                className="md:hidden fixed right-0 top-1/2 -translate-y-1/2 bg-[#050505] border-y border-l border-white/20 p-3 rounded-l-xl text-[#00ff88] shadow-2xl z-[100] hover:border-[#00ff88] transition-all active:scale-95"
            >
                <div className="flex flex-col items-center gap-1">
                    <Maximize2 size={18} />
                    <span className="text-[8px] font-bold tracking-tighter uppercase font-mono">Map</span>
                </div>
            </button>
        )}

        <div
          ref={mapRef}
          onDoubleClick={(e) => {
            e.stopPropagation();
            setIsExpanded(!isExpanded);
          }}
          onWheel={handleWheel}
          onMouseDown={handleMouseDown}
          onMouseMove={handleMouseMove}
          onMouseUp={handleMouseUp}
          onMouseLeave={handleMouseLeave}
          className={`
            relative overflow-hidden shadow-2xl rounded transition-all duration-300 bg-[#050505] border
            ${isExpanded
              ? "w-[85vmin] h-[85vmin] border-[#00ff88]/50 rounded-lg shadow-[0_0_50px_rgba(0,255,136,0.1)]"
              : "hidden md:block w-[100px] h-[100px] border-white/10 hover:border-[#00ff88] cursor-pointer"
            }
            ${
              isExpanded 
                ? (transform.k > 1 ? (isDragging ? "cursor-grabbing" : "cursor-grab") : "cursor-crosshair")
                : "cursor-pointer"
            }
          `}
        >
          <div 
            className="w-full h-full absolute inset-0 will-change-transform origin-top-left"
            style={{ 
                transition: isDragging ? 'none' : 'transform 0.1s ease-out',
                transform: isExpanded 
                    ? `translate3d(${transform.x}px, ${transform.y}px, 0) scale(${transform.k})` 
                    : `translate3d(0,0,0) scale(1)`
            }}
          >
            {isExpanded && (
              <div className="absolute inset-0 w-full h-full pointer-events-none"
                style={{ 
                  backgroundImage: 'linear-gradient(#00ff88 1px, transparent 1px), linear-gradient(90deg, #00ff88 1px, transparent 1px)', 
                  backgroundSize: '40px 40px',
                  opacity: 0.2, 
                }}>
              </div>
            )}

            <MinimapIndicator ref={indicatorRef} isExpanded={isExpanded} />

            {articles.map(art => (
              <ArticleDot 
                key={art.id} 
                art={art} 
                worldLimit={worldLimit} 
                isExpanded={isExpanded} 
                onDotClick={handleDotClick} 
                />
              ))}
          </div>
          
          <div className={`absolute top-2 right-2 text-[#00ff88] pointer-events-none transition-opacity duration-300 z-10 ${isExpanded ? 'opacity-0' : 'opacity-0 hover:opacity-100'}`}>
            <Maximize2 size={14} />
          </div>

          {isExpanded && (
             <div className="absolute bottom-2 right-2 bg-black/80 border border-white/20 text-[#00ff88] text-[9px] font-[Courier] px-2 py-1 pointer-events-none select-none">
                 {Math.round(transform.k * 100)}%
             </div>
          )}
        </div>

        {isExpanded && (
          <div className="absolute bottom-8 left-1/2 -translate-x-1/2 font-[Courier_New] text-[#00ff88]/50 text-xs tracking-[0.2em] pointer-events-none select-none animate-pulse">
            SCROLL TO ZOOM {transform.k > 1 ? "• DRAG TO PAN" : ""}
          </div>
        )}
      </div>
    </>
  );
};

export default Minimap;
