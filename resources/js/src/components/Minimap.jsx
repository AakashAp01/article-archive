import React, { useState, useRef } from 'react';
import { Maximize2, X, Scan } from 'lucide-react';

const Minimap = ({ articles, onNavigate, onJump, indicatorRef, worldLimit }) => {
  const [isExpanded, setIsExpanded] = useState(false);
  
  // Transform State: Scale (Zoom) and Translation (Pan)
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

  // --- FIXED ZOOM LOGIC ---
  const handleWheel = (e) => {
    if (!isExpanded) return;
    e.stopPropagation();
    e.preventDefault();

    const rect = mapRef.current.getBoundingClientRect();
    
    // 1. Calculate new scale
    const delta = e.deltaY > 0 ? -0.2 : 0.2;
    const newScale = Math.min(Math.max(transform.k + delta, 1), 4);
    
    if (newScale === transform.k) return; // No change needed

    // 2. Calculate mouse position relative to container
    const mouseX = e.clientX - rect.left;
    const mouseY = e.clientY - rect.top;

    // 3. Calculate the "World Point" under the mouse before zooming
    // This is the specific pixel on the map image itself
    const worldX = (mouseX - transform.x) / transform.k;
    const worldY = (mouseY - transform.y) / transform.k;

    // 4. Calculate new Translate to keep that World Point under the mouse
    let newX = mouseX - (worldX * newScale);
    let newY = mouseY - (worldY * newScale);

    // 5. Boundary Clamping (Crucial for alignment feel)
    // Ensure we don't drag/zoom past the edges (no white space visible)
    // The map width is rect.width * newScale. 
    // The max X translate is 0 (left edge), min X is rect.width - mapWidth
    const minX = rect.width - (rect.width * newScale);
    const minY = rect.height - (rect.height * newScale);

    newX = Math.min(0, Math.max(newX, minX));
    newY = Math.min(0, Math.max(newY, minY));

    setTransform({ k: newScale, x: newX, y: newY });
  };

  // --- FIXED DRAG LOGIC ---
  const handleMouseDown = (e) => {
    if (!isExpanded) return;
    
    // FIX 1: Only allow drag if zoomed in
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

    // Apply same clamping during drag
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
       // Allow click-to-jump even if not dragging (when at 100% zoom)
       onJump(e, mapRef.current.getBoundingClientRect());
    }
  };

  const handleMouseLeave = () => {
    if (isDragging) setIsDragging(false);
  };

  return (
    <>
      <div
        className={`transition-all duration-300 ease-[cubic-bezier(0.25,0.8,0.25,1)]
          ${isExpanded
            ? "fixed inset-0 z-[200] bg-black/80 backdrop-blur-md flex items-center justify-center pointer-events-auto"
            : "absolute top-4 right-4 md:relative md:top-auto md:right-auto pointer-events-auto z-[80]"
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

        {/* MAP CONTAINER */}
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
            relative overflow-hidden shadow-2xl transition-all duration-300 bg-[#050505] border
            ${isExpanded
              ? "w-[80vmin] h-[80vmin] border-[#00ff88]/50"
              : "w-[100px] h-[100px] border-white/10 hover:border-[#00ff88] cursor-pointer"
            }
            ${/* Dynamic Cursor Class */
              isExpanded 
                ? (transform.k > 1 ? (isDragging ? "cursor-grabbing" : "cursor-grab") : "cursor-crosshair")
                : "cursor-pointer"
            }
          `}
        >
          {/* ZOOMABLE LAYER */}
          <div 
            className="w-full h-full absolute inset-0 will-change-transform origin-top-left"
            style={{ 
                transition: isDragging ? 'none' : 'transform 0.1s ease-out',
                transform: isExpanded 
                    ? `translate3d(${transform.x}px, ${transform.y}px, 0) scale(${transform.k})` 
                    : `translate3d(0,0,0) scale(1)`
            }}
          >
            {/* Grid Background */}
            {isExpanded && (
              <div className="absolute inset-0 w-full h-full pointer-events-none"
                style={{ 
                  // Adjusted grid to fit the container perfectly so zooming feels grounded
                  backgroundImage: 'linear-gradient(#00ff88 1px, transparent 1px), linear-gradient(90deg, #00ff88 1px, transparent 1px)', 
                  backgroundSize: '40px 40px',
                  opacity: 0.2, 
                }}>
              </div>
            )}

            <div
              ref={indicatorRef}
              className="absolute z-[51] flex items-center justify-center pointer-events-none w-0 h-0"
              style={{ left: '50%', top: '50%', transform: 'translate(-50%, -50%)' }}
            >
              <div className={`absolute border border-dashed border-[#00ff88] rounded-full animate-[spin_4s_linear_infinite] opacity-60 ${isExpanded ? "w-16 h-16" : "w-6 h-6"}`}></div>
              <div className={`absolute border border-[#00ff88] rounded-full flex items-center justify-center ${isExpanded ? "w-8 h-8 opacity-80" : "w-3 h-3 opacity-0"}`}>
                 <Scan size={isExpanded ? 16 : 0} className="text-[#00ff88]" />
              </div>
              <div className={`absolute bg-[#00ff88] rounded-full shadow-[0_0_15px_#00ff88] ${isExpanded ? "w-2 h-2 animate-pulse" : "w-1.5 h-1.5"}`}></div>
            </div>

            {articles.map(art => {
              const leftPct = 50 + ((art.x / worldLimit) * 50);
              const topPct = 50 + ((art.y / worldLimit) * 50);
              const color = art.category ? art.category.color_code : '#00ff88';

              return (
                <div
                  key={art.id}
                  title={art.title}
                  onMouseDown={(e) => e.stopPropagation()} 
                  onMouseUp={(e) => handleDotClick(e, art)}
                  className={`
                    absolute rounded-full cursor-pointer transition-all duration-200 z-50
                    hover:shadow-[0_0_20px_${color}] hover:scale-150
                    ${isExpanded ? "w-3 h-3 ring-2 ring-black bg-black" : "w-1.5 h-1.5 bg-current"}
                  `}
                  style={{
                    backgroundColor: isExpanded ? 'black' : color,
                    borderColor: color,
                    borderWidth: isExpanded ? '2px' : '0px',
                    left: `${leftPct}%`,
                    top: `${topPct}%`,
                    transform: 'translate(-50%, -50%)'
                  }}
                />
              );
            })}
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
            SCROLL TO ZOOM {transform.k > 1 ? "// DRAG TO SCAN" : ""}
          </div>
        )}
      </div>
    </>
  );
};

export default Minimap;