import React from 'react';
import Card from './Card';

const WorldViewport = ({ 
    viewportRef, 
    worldRef, 
    worldLimit, 
    visibleArticles, 
    highlightedId, 
    onCardClick 
}) => {
    return (
        <div id="viewport" ref={viewportRef} className="w-full h-full relative overflow-hidden cursor-grab active:cursor-grabbing">
            <div id="world" ref={worldRef} className="absolute top-1/2 left-1/2 w-0 h-0">

                {}
                <div className="grid-bg absolute -top-[50000px] -left-[50000px] w-[100000px] h-[100000px] opacity-10 pointer-events-none"></div>

                {}
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

                {}
                {visibleArticles.map(art => (
                    <Card
                        key={art.id}
                        data={art}
                        onClick={onCardClick}
                        isHighlighted={highlightedId === art.id}
                    />
                ))}
            </div>
        </div>
    );
};

export default WorldViewport;
