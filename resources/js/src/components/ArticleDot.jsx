import React from 'react';

const ArticleDot = ({ art, worldLimit, isExpanded, onDotClick }) => {
    const leftPct = 50 + ((art.x / worldLimit) * 50);
    const topPct = 50 + ((art.y / worldLimit) * 50);
    const color = art.category ? art.category.color_code : '#00ff88';

    return (
        <div
            key={art.id}
            title={art.title}
            onMouseDown={(e) => e.stopPropagation()} 
            onMouseUp={(e) => onDotClick(e, art)}
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
};

export default ArticleDot;
