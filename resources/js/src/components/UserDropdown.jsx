import React from 'react';

const UserDropdown = ({ user, isDropdownOpen, setIsDropdownOpen, handleLogout }) => {
    return (
        <div className="relative">
            <button 
                onClick={() => setIsDropdownOpen(!isDropdownOpen)}
                className="flex items-center gap-3 pl-4 focus:outline-none group"
            >
                {/* Name */}
                <div className="text-right hidden lg:block">
                    <div className="text-xs font-bold text-white uppercase tracking-wider group-hover:text-[#00ff88] transition-colors">
                        {user.name}
                    </div>
                </div>

                {/* Avatar */}
                <div className="h-8 w-8 rounded-full border border-white/20 overflow-hidden group-hover:border-[#00ff88] group-hover:shadow-[0_0_10px_rgba(0,255,136,0.2)] transition-all duration-300">
                    <img 
                        src={user.avatar}
                        alt={user.name} 
                        className="h-full w-full object-cover"
                    />
                </div>

                {/* Down Arrow */}
                <svg 
                    className={`w-3 h-3 text-[#666] group-hover:text-white transition-transform duration-200 ${isDropdownOpen ? 'rotate-180' : ''}`} 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            {/* Dropdown Menu */}
            {isDropdownOpen && (
                <div className="absolute right-0 mt-4 w-48 bg-[#0a0a0f] border border-white/10 shadow-2xl py-1 z-50 origin-top-right rounded-md overflow-hidden">
                    
                    {/* Mobile Name Display */}
                    <div className="px-4 py-2 border-b border-white/5 lg:hidden">
                        <p className="text-xs font-bold text-white uppercase tracking-wider">{user.name}</p>
                    </div>

                    <a href="/profile" className="flex items-center gap-2 px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-[#00ff88] transition-colors">
                        <span>Profile</span>
                    </a>

                    <a href="/saved-articles" className="flex items-center gap-2 px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-[#00ff88] transition-colors">
                        <span>Saved Articles</span>
                    </a>

                    <div className="border-t border-white/5 my-1"></div>

                    <button 
                        onClick={handleLogout}
                        className="w-full text-left px-4 py-2 text-xs text-red-500 hover:bg-red-500/10 hover:text-red-400 tracking-widest transition-colors flex items-center gap-2"
                    >
                        Logout
                    </button>
                </div>
            )}
        </div>
    );
};

export default UserDropdown;
