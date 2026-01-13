import { useEffect, useRef, useState, useCallback } from 'react';
import debounce from 'lodash/debounce';

export const useWorldEngine = (viewportRef, worldRef, minimapIndicatorRef, coordRef, activeArticle, setHighlightedId, worldLimit) => {
  
  const [cameraPosition, setCameraPosition] = useState({ x: 0, y: 0 });

  const physics = useRef({
    isDragging: false,
    startX: 0, startY: 0,
    currentX: 0, currentY: 0,
    targetX: 0, targetY: 0
  });

  // Clamp within the dynamic world boundary
  const clamp = (val, limit) => Math.min(Math.max(val, -limit), limit);

  const syncApiState = useCallback(debounce((x, y) => {
      setCameraPosition({ x, y });
  }, 300), []);

  // --- Animation Loop ---
  useEffect(() => {
    let animationFrameId;
    const animate = () => {
      const p = physics.current;
      
      // Lerp
      p.currentX += (p.targetX - p.currentX) * 0.1;
      p.currentY += (p.targetY - p.currentY) * 0.1;

      // 1. Update World
      if (worldRef.current) {
        worldRef.current.style.transform = `translate(${p.currentX}px, ${p.currentY}px)`;
      }

      // 2. Update Minimap Indicator (The Fix)
      if (minimapIndicatorRef.current && worldLimit > 0) {
        // Calculate Percentage based on Dynamic Limit
        // If World X is -Limit (Left), Indicator should be 100% (Right)
        const pctX = (p.currentX / worldLimit) * 50; 
        const pctY = (p.currentY / worldLimit) * 50;

        // Invert logic: Dragging Left (Negative X) means viewing Right area
        const indX = 50 - pctX;
        const indY = 50 - pctY;
        
        minimapIndicatorRef.current.style.left = `${indX}%`;
        minimapIndicatorRef.current.style.top = `${indY}%`;
        minimapIndicatorRef.current.style.transform = `translate(-50%, -50%)`;
      }

      // 3. Update Text
      if (coordRef && coordRef.current) {
        coordRef.current.innerText = `X: ${Math.round(-p.currentX)} | Y: ${Math.round(-p.currentY)}`;
      }

      animationFrameId = requestAnimationFrame(animate);
    };
    animate();
    return () => cancelAnimationFrame(animationFrameId);
  }, [worldLimit]); // Re-bind if limit changes

  // --- Event Listeners ---
  useEffect(() => {
    const view = viewportRef.current;
    if (!view) return;

    const onMouseDown = (e) => {
      if (e.target.closest('input, button, .card')) return;
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
      if (activeArticle) return;
      e.preventDefault();
      const rawX = physics.current.targetX - (e.deltaX * 0.8);
      const rawY = physics.current.targetY - (e.deltaY * 0.8);
      
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

  // --- Helpers ---
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
     // Calculate click percentage (-0.5 to 0.5)
     const clickX = e.clientX - rect.left;
     const clickY = e.clientY - rect.top;
     
     const pctX = (clickX / rect.width) - 0.5;
     const pctY = (clickY / rect.height) - 0.5;

     // Convert percentage to World Coordinates
     // If I click Right (0.5), I want camera to move Right.
     // Moving camera Right means World must move Left (negative).
     const targetX = -(pctX * (worldLimit * 2));
     const targetY = -(pctY * (worldLimit * 2));

     physics.current.targetX = clamp(targetX, worldLimit);
     physics.current.targetY = clamp(targetY, worldLimit);
     
     syncApiState(targetX, targetY);
  };

  return { navigateToCard, jumpToMinimap, worldLimit, cameraPosition };
};