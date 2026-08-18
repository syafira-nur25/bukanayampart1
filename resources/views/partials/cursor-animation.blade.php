{{-- ===== ANIMASI KURSOR AYAM + JEJAK TELUR ===== --}}
<style>
@media (pointer: fine) {
  #cursorChicken, .cursor-egg {
    position: fixed;
    top: 0; left: 0;
    pointer-events: none;
    z-index: 99999;
  }
  #cursorChicken {
    width: 46px; height: 46px;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity .25s ease, transform .25s ease;
    filter: drop-shadow(0 4px 6px rgba(93,64,55,.25));
  }
  #cursorChicken.on { opacity: 1; }
  #cursorChicken.is-hover { transform: translate(-50%, -50%) scale(1.25); }
  #cursorChicken svg { width: 100%; height: 100%; display: block; }

  #cursorChicken .wing {
    transform-origin: 50% 20%;
    animation: wingFlap .45s ease-in-out infinite;
  }
  @keyframes wingFlap {
    0%, 100% { transform: rotate(-8deg); }
    50%      { transform: rotate(18deg); }
  }

  #cursorChicken .head {
    transform-origin: 50% 90%;
    animation: headBob .6s ease-in-out infinite;
  }
  @keyframes headBob {
    0%, 100% { transform: rotate(-3deg) translateY(0); }
    50%      { transform: rotate(3deg) translateY(-1px); }
  }

  .cursor-egg {
    width: 10px; height: 13px;
    background: linear-gradient(180deg, #fff8ee, #e8d5bd);
    border: 1px solid rgba(93, 64, 55, .25);
    border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
    will-change: transform, opacity;
  }
}
</style>

<div id="cursorChicken">
  <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
    <path d="M10 38 Q4 30 8 22 Q10 30 14 34 Q8 28 12 20 Q14 28 18 34 Q14 26 18 18 Q20 28 22 36 Z" fill="#5d4037"/>
    <line x1="28" y1="50" x2="26" y2="58" stroke="#f4b400" stroke-width="2.5" stroke-linecap="round"/>
    <line x1="36" y1="50" x2="38" y2="58" stroke="#f4b400" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M22 58 L26 58 L30 58 M26 58 L26 61" stroke="#f4b400" stroke-width="2" stroke-linecap="round" fill="none"/>
    <path d="M34 58 L38 58 L42 58 M38 58 L38 61" stroke="#f4b400" stroke-width="2" stroke-linecap="round" fill="none"/>
    <ellipse cx="32" cy="40" rx="18" ry="14" fill="#fff8ee"/>
    <ellipse cx="32" cy="42" rx="16" ry="11" fill="#fff"/>
    <g class="wing">
      <path d="M22 38 Q14 40 16 48 Q22 44 28 44 Q24 42 22 38 Z" fill="#e8d5bd"/>
    </g>
    <g class="head">
      <path d="M40 14 Q42 8 44 13 Q46 7 48 13 Q50 9 51 15 Q48 17 40 16 Z" fill="#d93636"/>
      <circle cx="46" cy="24" r="11" fill="#fff8ee"/>
      <circle cx="46" cy="25" r="9" fill="#fff"/>
      <circle cx="42" cy="27" r="2" fill="#f4b8b8" opacity=".7"/>
      <circle cx="49" cy="22" r="2.2" fill="#2d1b16"/>
      <circle cx="49.6" cy="21.3" r=".7" fill="#fff"/>
      <path d="M55 24 L62 26 L55 28 Z" fill="#f4b400"/>
      <path d="M55 26 L60 26" stroke="#c79000" stroke-width=".5"/>
      <path d="M50 29 Q52 33 50 33 Q48 33 50 29 Z" fill="#d93636"/>
    </g>
  </svg>
</div>

<script>
(function () {
  if (!window.matchMedia('(pointer: fine)').matches) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var chicken = document.getElementById('cursorChicken');
  if (!chicken) return;

  var mx = -100, my = -100, rx = -100, ry = -100;
  var lastX = -100, lastY = -100;
  var aktif = false;
  var angle = 0;

  window.addEventListener('mousemove', function (e) {
    mx = e.clientX; my = e.clientY;
    if (!aktif) { aktif = true; rx = mx; ry = my; chicken.classList.add('on'); }

    var dx = mx - lastX;
    var dy = my - lastY;
    if (Math.hypot(dx, dy) > 2) {
      var target = Math.atan2(dy, dx) * 180 / Math.PI;
      target = Math.max(-25, Math.min(25, target));
      angle += (target - angle) * 0.2;
      lastX = mx; lastY = my;
    }

    spawnTrail(mx, my);
  }, { passive: true });

  document.documentElement.addEventListener('mouseleave', function () {
    aktif = false;
    chicken.classList.remove('on');
  });

  (function loop() {
    if (aktif) {
      rx += (mx - rx) * 0.18;
      ry += (my - ry) * 0.18;
      chicken.style.left = rx + 'px';
      chicken.style.top  = ry + 'px';
      chicken.style.transform = 'translate(-50%, -50%) rotate(' + angle.toFixed(1) + 'deg)';
    }
    requestAnimationFrame(loop);
  })();

  document.addEventListener('mouseover', function (e) {
    var hit = e.target.closest && e.target.closest('a, button, select, input, textarea, [role="button"]');
    chicken.classList.toggle('is-hover', !!hit);
  });

  var trailX = 0, trailY = 0;
  function spawnTrail(x, y) {
    if (Math.hypot(x - trailX, y - trailY) < 28) return;
    trailX = x; trailY = y;

    var el = document.createElement('div');
    el.className = 'cursor-egg';
    el.style.left = x + 'px';
    el.style.top  = y + 'px';
    document.body.appendChild(el);

    el.animate([
      { transform: 'translate(-50%, -50%) scale(1) rotate(-6deg)', opacity: 0.9 },
      { transform: 'translate(-50%, -20%) scale(0.2) rotate(14deg)', opacity: 0 }
    ], { duration: 650, easing: 'ease-out' }).onfinish = function () { el.remove(); };
  }

  window.addEventListener('click', function (e) {
    for (var i = 0; i < 8; i++) {
      var p = document.createElement('div');
      p.className = 'cursor-egg';
      p.style.left = e.clientX + 'px';
      p.style.top  = e.clientY + 'px';
      document.body.appendChild(p);

      var ang = (Math.PI * 2 / 8) * i + Math.random() * 0.5;
      var d   = 26 + Math.random() * 26;

      p.animate([
        { transform: 'translate(-50%, -50%) scale(1)', opacity: 1 },
        { transform: 'translate(calc(-50% + ' + (Math.cos(ang) * d) + 'px), calc(-50% + ' + (Math.sin(ang) * d) + 'px)) scale(0.25)', opacity: 0 }
      ], { duration: 520, easing: 'cubic-bezier(.15,.6,.4,1)' })
      .onfinish = (function (node) { return function () { node.remove(); }; })(p);
    }
  });
})();
</script>
