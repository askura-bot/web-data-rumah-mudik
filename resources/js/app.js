// js/app.js

import './bootstrap';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Fix marker icon path issue ketika bundled dengan Vite
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

// Expose L secara global agar bisa dipakai di script inline Blade
window.L = L;
