import React, { useState, useEffect, useRef } from 'react';
import { Search as SearchIcon, Loader2 } from 'lucide-react';

const Search = ({ onNavigate }) => {
  const [query, setQuery] = useState('');
  const [suggestions, setSuggestions] = useState([]);
  const [loading, setLoading] = useState(false);
  const [isFocused, setIsFocused] = useState(false);
  
  // Use a ref to check click outside if needed, though blur handles most cases
  const containerRef = useRef(null);

  useEffect(() => {
    if (query.length < 2) {
      setSuggestions([]);
      return;
    }

    const delayDebounceFn = setTimeout(() => {
      setLoading(true);
      fetch(`/articles/search?q=${query}`)
        .then(response => response.json())
        .then(data => {
          setSuggestions(data.data || []);
          setLoading(false);
        })
        .catch(error => {
          console.error("Search Error:", error);
          setLoading(false);
        });
    }, 300);

    return () => clearTimeout(delayDebounceFn);
  }, [query]);

  const handleSelect = (article) => {
    if (onNavigate) {
      onNavigate(article);
    }
    setQuery('');
    setSuggestions([]);
  };

  const handleKeyDown = (e) => {
    if (e.key === 'Enter' && suggestions.length > 0) {
      handleSelect(suggestions[0]);
    }
  };

  useEffect(() => {
    const handleGlobalKeyDown = (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.getElementById('search-input')?.focus();
      }
    };
    window.addEventListener('keydown', handleGlobalKeyDown);
    return () => window.removeEventListener('keydown', handleGlobalKeyDown);
  }, []);

  const hasSuggestions = suggestions.length > 0;

  return (
    <div ref={containerRef} className="pointer-events-auto w-full md:w-auto flex flex-col items-center z-[100]">
      <div className="relative w-[300px] md:w-[400px]">
        
        {/* Icon (Left Aligned) */}
        <div className={`absolute left-0 bottom-3 transition-colors duration-300 ${isFocused || query ? 'text-[#00ff88]' : 'text-[#666]'}`}>
            {loading ? (
                <Loader2 size={18} className="animate-spin" />
            ) : (
                <SearchIcon size={18} />
            )}
        </div>

        {/* Input (Bottom Line Only) */}
        <input 
          id="search-input"
          type="text" 
          value={query}
          onChange={(e) => setQuery(e.target.value)}
          onFocus={() => setIsFocused(true)}
          onBlur={() => setTimeout(() => setIsFocused(false), 200)}
          onKeyDown={handleKeyDown}
          className="w-full bg-transparent text-[#e0e0e0] pl-8 pr-4 py-2 text-sm outline-none 
            border-b border-white/20 focus:border-[#00ff88] transition-all duration-300 
            font-[Courier_New] placeholder-[#666] tracking-wide"
          placeholder="Search Articles..."
          autoComplete="off"
        />
        
        {/* Suggestions Dropdown */}
        {(hasSuggestions) && (
          <div 
            className="absolute top-full left-0 w-full mt-2 bg-[#050505]/95 border border-white/10 backdrop-blur-xl max-h-60 overflow-y-auto shadow-2xl
            
            /* SCROLLBAR CUSTOMIZATION */
            scrollbar-thin
            [&::-webkit-scrollbar]:w-1
            [&::-webkit-scrollbar-track]:bg-transparent
            [&::-webkit-scrollbar-thumb]:bg-[#333]
            [&::-webkit-scrollbar-thumb]:hover:bg-[#00ff88]
            "
          >
            {suggestions.map(s => {
                const colorCode = s.category ? s.category.color_code : '#666';
                const catName = s.category ? s.category.name : 'UNCATEGORIZED';

                return (
                  <div 
                    key={s.id}
                    onMouseDown={(e) => { e.preventDefault(); handleSelect(s); }}
                    className="group px-4 py-3 border-b border-white/5 text-xs font-[Courier_New] text-[#888] hover:bg-white/5 cursor-pointer flex justify-between items-center transition-colors last:border-0"
                  >
                    <span className="group-hover:text-white transition-colors truncate pr-4">{s.title}</span>
                    <div className="flex items-center gap-2 shrink-0">
                        <span 
                            className="w-1.5 h-1.5 rounded-full"
                            style={{ backgroundColor: colorCode, boxShadow: `0 0 5px ${colorCode}` }}
                        ></span>
                        <span className="opacity-50 text-[10px] uppercase tracking-wider">{catName}</span>
                    </div>
                  </div>
                );
            })}
          </div>
        )}
      </div>
    </div>
  );
};

export default Search;