import { useEffect, useRef, useState, useCallback } from 'react';
import debounce from 'lodash/debounce';

export const useWorldEngine = (viewportRef, worldRef, minimapIndicatorRef, coordRef, activeArticle, setActiveArticle, setHighlightedId, worldLimit) => {
  
  const [cameraPosition, setCameraPosition] = useState({ x: 0, y: 0 });

  const physics = useRef({
    isDragging: false,
    startX: 0, startY: 0,
    currentX: 0, currentY: 0,
    targetX: 0, targetY: 0
  });

  const clamp = (val, limit) => Math.min(Math.max(val, -limit), limit);

  const syncApiState = useCallback(debounce((x, y) => {
      setCameraPosition({ x, y });
  }, 300), []);

  useEffect(() => {
    let animationFrameId;
    const animate = () => {
      const p = physics.current;
      
      p.currentX += (p.targetX - p.currentX) * 0.1;
      p.currentY += (p.targetY - p.currentY) * 0.1;

      if (worldRef.current) {
        worldRef.current.style.transform = `translate(${p.currentX}px, ${p.currentY}px)`;
      }

      if (minimapIndicatorRef.current && worldLimit > 0) {
        
        const pctX = (p.currentX / worldLimit) * 50; 
        const pctY = (p.currentY / worldLimit) * 50;

        const indX = 50 - pctX;
        const indY = 50 - pctY;
        
        minimapIndicatorRef.current.style.left = `${indX}%`;
        minimapIndicatorRef.current.style.top = `${indY}%`;
        minimapIndicatorRef.current.style.transform = `translate(-50%, -50%)`;
      }

      if (coordRef && coordRef.current) {
        coordRef.current.innerText = `X: ${Math.round(-p.currentX)} | Y: ${Math.round(-p.currentY)}`;
      }

      animationFrameId = requestAnimationFrame(animate);
    };
    animate();
    return () => cancelAnimationFrame(animationFrameId);
  }, [worldLimit]); 

  useEffect(() => {
    const view = viewportRef.current;
    if (!view) return;

    const onMouseDown = (e) => {
      
      if (e.target.closest('input, button, a')) return;
      
      if (document.activeElement instanceof HTMLElement) {
          document.activeElement.blur();
      }

      if (activeArticle) {
          setActiveArticle(null);
      }
      
      setHighlightedId(null);
      physics.current.isDragging = true;
      physics.current.startX = e.clientX - physics.current.targetX;
      physics.current.startY = e.clientY - physics.current.targetY;
      view.style.cursor = 'grabbing';
    };

    const onMouseMove = (e) => {
      if (!physics.current.isDragging) return;
      e.preventDefault();
      const rawX = e.clientX - physics.current.startX;
      const rawY = e.clientY - physics.current.startY;
      
      physics.current.targetX = clamp(rawX, worldLimit);
      physics.current.targetY = clamp(rawY, worldLimit);
      
      syncApiState(physics.current.targetX, physics.current.targetY);
    };

    const onMouseUp = () => {
      physics.current.isDragging = false;
      view.style.cursor = 'grab';
      syncApiState(physics.current.targetX, physics.current.targetY);
    };

    const onWheel = (e) => {
      
      e.preventDefault();
      const rawX = physics.current.targetX - (e.deltaX * 1.5); 
      const rawY = physics.current.targetY - (e.deltaY * 1.5);
      
      physics.current.targetX = clamp(rawX, worldLimit);
      physics.current.targetY = clamp(rawY, worldLimit);
      
      syncApiState(physics.current.targetX, physics.current.targetY);
    };

    view.addEventListener('mousedown', onMouseDown);
    window.addEventListener('mousemove', onMouseMove);
    window.addEventListener('mouseup', onMouseUp);
    view.addEventListener('wheel', onWheel, { passive: false });

    return () => {
      view.removeEventListener('mousedown', onMouseDown);
      window.removeEventListener('mousemove', onMouseMove);
      window.removeEventListener('mouseup', onMouseUp);
      view.removeEventListener('wheel', onWheel);
    };
  }, [activeArticle, syncApiState, worldLimit]);

  const navigateToCard = (cardData) => {
    const cardWidth = 320; 
    const cardHeight = 420;
    const targetX = -(cardData.x + (cardWidth / 2));
    const targetY = -(cardData.y + (cardHeight / 2));
    
    physics.current.targetX = clamp(targetX, worldLimit);
    physics.current.targetY = clamp(targetY, worldLimit);
    
    setHighlightedId(cardData.id);
    syncApiState(targetX, targetY);
  };

  const jumpToMinimap = (e, rect) => {
     
     const clickX = e.clientX - rect.left;
     const clickY = e.clientY - rect.top;
     
     const pctX = (clickX / rect.width) - 0.5;
     const pctY = (clickY / rect.height) - 0.5;

     const targetX = -(pctX * (worldLimit * 2));
     const targetY = -(pctY * (worldLimit * 2));

     physics.current.targetX = clamp(targetX, worldLimit);
     physics.current.targetY = clamp(targetY, worldLimit);
     
     syncApiState(targetX, targetY);
  };

  return { navigateToCard, jumpToMinimap, worldLimit, cameraPosition };
};