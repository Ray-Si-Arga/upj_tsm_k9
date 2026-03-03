import { createRoot } from "react-dom/client";
import AppWidget from "./AppWidget";
import "./index.css";

// Ekspos ke global window
(window as any).BengkelCalendar = {
  render: (elementId: string) => {
    const el = document.getElementById(elementId);
    if (!el) {
      console.error(`Element dengan id "${elementId}" tidak ditemukan.`);
      return;
    }
    const root = createRoot(el);
    root.render(<AppWidget />);
  },
  getEvents: () => {
    try {
      return JSON.parse(localStorage.getItem('bengkel-calendar-events') || '[]');
    } catch {
      return [];
    }
  }
};
