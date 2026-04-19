import React from 'react';
import SocialLinks from './SocialLinks';
import CoordinateDisplay from './CoordinateDisplay';
import Minimap from './Minimap';

const Footer = ({ 
    coordRef, 
    mapData, 
    SCALE_FACTOR, 
    navigateToCard, 
    jumpToMinimap, 
    minimapIndicatorRef, 
    worldLimit 
}) => {
    return (
        <div className="fixed inset-0 pointer-events-none z-40 p-4 md:p-8 flex flex-col justify-end">
            <div className="relative w-full flex items-end justify-between">
                
                {/* 1. Left: Socials & Text */}
                <SocialLinks />

                {/* 2. Center: Coordinates */}
                <CoordinateDisplay ref={coordRef} />

                {/* 3. Right: Minimap & Instructions */}
                <div className="flex flex-col items-end gap-2 md:gap-4 pointer-events-auto">
                    
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
    );
};

export default Footer;
