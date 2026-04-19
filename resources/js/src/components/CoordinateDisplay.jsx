import React, { forwardRef } from 'react';

const CoordinateDisplay = forwardRef((props, ref) => {
    return (
        <div className="absolute left-1/2 -translate-x-1/2 bottom-0 pointer-events-auto">
            <div className="px-5 py-2 bg-black/80 border border-white/10 rounded-full backdrop-blur-sm flex items-center gap-3 shadow-lg">
                <div className="text-[10px] font-[Courier_New] text-[#00ff88] tracking-widest font-bold">
                    <span ref={ref}>X: 0 | Y: 0</span>
                </div>
            </div>
        </div>
    );
});

CoordinateDisplay.displayName = 'CoordinateDisplay';

export default CoordinateDisplay;
