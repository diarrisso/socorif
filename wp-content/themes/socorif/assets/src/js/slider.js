/**
 * Swiper Slider Initialization
 *
 * This file is imported in the main app.js and makes Swiper available globally
 * for use with Alpine.js x-data components in the slider block template.
 */

import Swiper from "swiper";
import {
  Navigation,
  Pagination,
  Autoplay,
  EffectFade,
  EffectCube,
  EffectCoverflow,
} from "swiper/modules";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/effect-fade";
import "swiper/css/effect-cube";
import "swiper/css/effect-coverflow";

// Make Swiper available globally for Alpine.js components
window.Swiper = Swiper;

// Configure default modules
Swiper.use([
  Navigation,
  Pagination,
  Autoplay,
  EffectFade,
  EffectCube,
  EffectCoverflow,
]);

// Export for ES modules
export default Swiper;
