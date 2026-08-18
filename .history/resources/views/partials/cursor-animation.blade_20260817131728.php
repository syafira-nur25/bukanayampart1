{{-- ===== ANIMASI KURSOR TELUR (BukanAyam) ===== --}}
<style>
@media (pointer: fine) {
  #cursorRing, .cursor-egg {
    position: fixed;
    top: 0; left: 0;
    pointer-events: none;
    z-index: 99999;
  }
  /* Cincin yang mengikuti kursor */
  #cursorRing {
    width: 34px; height: 34px;
    border: 2px solid rgba(109, 76, 65, .45);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width .25s ease, height .25s ease, border-color .25s ease, background-color .25s ease;
  }
  #cursorRing.is-hover {
    width: 52px; height: 52px;
    border-color: #d7a86e;
    background: rgba(215, 168, 110, .12);
  }
  /* Telur kecil untuk jejak & pecahan */
  .cursor-egg {
    width: 10px; height: 13px;
    background: linear-gradient(180deg, #fff8ee, #e8d5bd);
    border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
    box-shadow: 0 1px 3px rgba(0,0,0,.15);
    will-change: transform, opacity;
  }
}
</style>

<div id="cursorRing"></div>

<script>
(function () {
  // Hanya untuk perangkat ber-mouse, dan hormati reduce-motion
  if (window.matchMedia('(pointer: coarse)').matches) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var ring = document.getElementById('cursorRing');
  var mx = innerWidth / 2, my = innerHeight / 2;
  var rx = mx, ry = my;

  addEventListener('mousemove', function (e) {
    mx = e.clientX; my = e.clientY;
    trail(e.clientX, e.clientY);
  }, { passive: true });

  // Cincin mengikuti dengan halus (sedikit "tertinggal" biar elegan)
  (function loop() {
    rx += (mx - rx) * 0.18;
    ry += (my - ry) * 0.18;
    ring.style.left = rx + 'px';
    ring.style.top  = ry + 'px';
    requestAnimationFrame(loop);
  })();

  // Membesar saat di atas elemen interaktif
  document.addEventListener('mouseover', function (e) {
    var hit = e.target.closest && e.target.closest('a, button, select, input, textarea, [role="button"]');
    ring.classList.toggle('is-hover', !!hit);
  });

  // Jejak telur kecil saat mouse bergerak
  var lastX = 0, lastY = 0;
  function trail(x, y) {
    if (Math.hypot(x - lastX, y - lastY) < 28) return;
    lastX = x; lastY = y;
    var el = document.createElement('div');
    el.className = 'cursor-egg';
    el.style.left = x + 'px';
    el.style.top  = y + 'px';
    document.body.appendChild(el);
    var a = el.animate([
      { transform: 'translate(-50%, -50%) scale(1) rotate(-6deg)', opacity: 0.9 },
      { transform: 'translate(-50%, -20%) scale(0.2) rotate(14deg)', opacity: 0 }
    ], { duration: 650, easing: 'ease-out' });
    a.onfinish = function () { el.remove(); };
  }

  // Klik = telur "pecah" menjadi 8 pecahan kecil
  addEventListener('click', function (e) {
    for (var i = 0; i < 8; i++) {
      var p = document.createElement('div');
      p.className = 'cursor-egg';
      p.style.left = e.clientX + 'px';
      p.style.top  = e.clientY + 'px';
      document.body.appendChild(p);
      var ang = (Math.PI * 2 / 8) * i + Math.random() * 0.5;
      var d   = 26 + Math.random() * 26;
      var dx  = Math.cos(ang) * d;
      var dy  = Math.sin(ang) * d;
      var a = p.animate([
        { transform: 'translate(-50%, -50%) scale(1)', opacity: 1 },
        { transform: 'translate(calc(-50% + ' + dx + 'px), calc(-50% + ' + dy + 'px)) scale(0.25)', opacity: 0 }
      ], { duration: 520, easing: 'cubic-bezier(.15,.6,.4,1)' });
      a.onfinish = (function (node) { return function () { node.remove(); }; })(p);
    }
  });
})();
</script>
