import { collapse } from "@alpinejs/collapse";
import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.start();
