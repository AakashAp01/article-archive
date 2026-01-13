import React from 'react';
import { ArrowRight, Heart } from 'lucide-react';
import thumbnailPlaceholder from '../../images/thumbnail.svg';

const Card = ({ data, isHighlighted, onClick }) => {

  const articleUrl = `/article/${data.slug}`;
  const colorCode = data.category ? data.category.color_code : '#00ff88';
  const catName = data.category ? data.category.name : 'UNCATEGORIZED';

  // Placeholder
  const thumbnailUrl = data.thumbnail || `https://placehold.co/600x400/111/333?text=${encodeURIComponent(data.title.substring(0, 10))}`;

  const likeCount = data.likes_count || 0;

  return (
    <div
      onClick={(e) => {
        e.stopPropagation();
        onClick(data);
      }}
      style={{
        '--cat-color': colorCode,
        transform: `translate(${data.x}px, ${data.y}px)`,
        borderColor: isHighlighted ? colorCode : undefined,
        boxShadow: isHighlighted ? `0 0 30px ${colorCode}40` : undefined
      }}
      className={`
        absolute w-[300px] md:w-[350px] h-[450px] md:h-[480px] 
        bg-[rgba(10,10,15,0.85)] border backdrop-blur-md p-6 rounded-sm 
        flex flex-col transition-all duration-500 origin-center cursor-pointer group hover:z-50
        
        border-[rgba(255,255,255,0.1)] hover:border-[var(--cat-color)]
        
        ${isHighlighted ? 'scale-105 z-40' : ''}
      `}
    >
      {/* Category Header */}
      <div
        className="font-[Courier_New] text-xs flex justify-between mb-4 shrink-0"
        style={{ color: colorCode }}
      >
        <span className="uppercase tracking-widest">{catName}</span>
        <span>
          {(() => {
            const d = new Date(data.date);
            const day = String(d.getDate()).padStart(2, "0");
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const year = d.getFullYear();
            return `${day}.${month}.${year}`;
          })()}
        </span>
      </div>

      {/* Thumbnail Image */}
      <div className="w-full h-40 mb-5 overflow-hidden rounded-sm bg-black/50 shrink-0 relative">
        <img
          src={thumbnailUrl}
          alt={data.title}
          className="w-full h-full object-cover opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out group-hover:grayscale-0"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-[rgba(10,10,15,0.9)] to-transparent opacity-60"></div>
      </div>

      {/* Content */}
      <div className="flex flex-col grow">
        <h2 className="text-xl md:text-2xl font-light leading-tight mb-3">
          <a
            href={articleUrl}
            className="text-gray-100 font-bold group-hover:text-[var(--cat-color)] transition-colors line-clamp-2"
          >
            {data.title}
          </a>
        </h2>
        <p className="text-sm text-[#888] leading-relaxed line-clamp-3 mb-4">
          {data.excerpt}
        </p>
      </div>

      {/* Footer */}
      <div className="mt-auto flex justify-between items-center pt-4 border-t border-white/5">
        <a
          href={articleUrl}
          className="font-[Courier_New] text-xs tracking-widest flex items-center transition-colors duration-300 hover:text-[var(--cat-color)]"
        >
          Read Article
          <ArrowRight
            className="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover:translate-x-2"
            style={{ color: colorCode }}
          />
        </a>

        <div className="flex items-center gap-2 text-[#666] group-hover:text-gray-300 transition-colors">
          <Heart
            size={16}
            className="fill-[var(--cat-color)] text-[var(--cat-color)] transition-colors duration-300"
          />
          <span className="font-[Courier_New] text-xs">{likeCount}</span>
        </div>
      </div>
    </div>
  );
};

export default Card;