import React, { forwardRef } from 'react';
import { Scan } from 'lucide-react';

const MinimapIndicator = forwardRef(({ isExpanded }, ref) => {
    return (
        <div
            ref={ref}
            className="absolute z-[51] flex items-center justify-center pointer-events-none w-0 h-0"
            style={{ left: '50%', top: '50%', transform: 'translate(-50%, -50%)' }}
        >
            <div className={`absolute border border-dashed border-[#00ff88] rounded-full animate-[spin_4s_linear_infinite] opacity-60 ${isExpanded ? "w-16 h-16" : "w-6 h-6"}`}></div>
            <div className={`absolute border border-[#00ff88] rounded-full flex items-center justify-center ${isExpanded ? "w-8 h-8 opacity-80" : "w-3 h-3 opacity-0"}`}>
                <Scan size={isExpanded ? 16 : 0} className="text-[#00ff88]" />
            </div>
            <div className={`absolute bg-[#00ff88] rounded-full shadow-[0_0_15px_#00ff88] ${isExpanded ? "w-2 h-2 animate-pulse" : "w-1.5 h-1.5"}`}></div>
        </div>
    );
});

MinimapIndicator.displayName = 'MinimapIndicator';

export default MinimapIndicator;
