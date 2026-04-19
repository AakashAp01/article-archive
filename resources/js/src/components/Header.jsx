import React, { useState, useEffect, useRef } from 'react';
import Search from './Search';
import UserDropdown from './UserDropdown';

const Header = ({ user, handleLogout, mapData, onNavigate }) => {
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);
    const dropdownRef = useRef(null);

    // Close dropdown if clicked outside
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setIsDropdownOpen(false);
            }
        };
        document.addEventListener("mousedown", handleClickOutside);
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    return (
        /* Main Container */
        <div className="fixed top-0 w-full bg-[#0a0a0f]/95 border-b border-white/5 z-30 backdrop-blur-md font-display transition-all">
            
            {/* INNER CONTAINER */}
            <div className="relative max-w-6xl mx-auto px-4 h-auto md:h-14 flex flex-wrap md:flex-nowrap items-center justify-between py-2 md:py-0">

                {/* 1. Left: LOGO */}
                <a href="/" className="flex items-center gap-2 group pointer-events-auto z-50">
                    <span className="text-lg font-semibold tracking-wide text-white group-hover:opacity-80 transition-opacity">
                        AkashAp<span className="text-[#00ff88]">.dev</span>
                    </span>
                </a>

                {/* 2. Center: SEARCH */}
                <div className="pointer-events-auto z-40 order-3 md:order-none w-full md:w-auto md:absolute md:left-1/2 md:-translate-x-1/2 flex justify-center mt-2 md:mt-0 pb-2 md:pb-0">
                    <Search articles={mapData} onNavigate={onNavigate} />
                </div>

                {/* 3. Right: AUTH / PROFILE */}
                <div className="pointer-events-auto z-50 flex items-center gap-6 justify-end" ref={dropdownRef}>
                    
                    {user ? (
                        <UserDropdown 
                            user={user} 
                            isDropdownOpen={isDropdownOpen} 
                            setIsDropdownOpen={setIsDropdownOpen} 
                            handleLogout={handleLogout} 
                        />
                    ) : (
                        /* Login Link */
                        <a 
                            href="/login"
                            className="text-sm font-bold text-[#00ff88] tracking-widest hover:underline decoration-[#00ff88] underline-offset-4 transition-all"
                        >
                            Login
                        </a>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Header;