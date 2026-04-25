import React from 'react';
import { Github, Twitter, Linkedin } from 'lucide-react';

const SocialLinks = () => {
    return (
        <div className="hidden md:flex items-center gap-6 pointer-events-auto">
            <div className="text-xs text-[#888] opacity-70 font-[Courier_New] tracking-widest">
                SCROLL / DRAG TO EXPLORE
            </div>
            <div className="w-8 h-[1px] bg-white/10"></div>
            <div className="flex items-center gap-4 text-[#888]">
                <a href="https://www.linkedin.com/in/aakashap"><Linkedin className="w-5 h-5 hover:text-[#00ff88] cursor-pointer hover:scale-110 transition-all" /></a>
                <a href="https://github.com/AakashAp01"><Github className="w-5 h-5 hover:text-[#00ff88] cursor-pointer hover:scale-110 transition-all" /></a>
                <a href="https://x.com/_akash_ap_"><Twitter className="w-5 h-5 hover:text-[#00ff88] cursor-pointer hover:scale-110 transition-all" /></a>
            </div>
        </div>
    );
};

export default SocialLinks;
