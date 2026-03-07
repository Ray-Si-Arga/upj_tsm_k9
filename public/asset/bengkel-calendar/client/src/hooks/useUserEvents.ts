import { useState, useEffect } from 'react';

export interface UserEvent {
  id: string;
  date: string;
  title: string;
  description?: string;
  isClosed: boolean;
  isOperational: boolean;
}

export function useUserEvents() {
  const [events, setEvents] = useState<UserEvent[]>([]);

  // Load events ONLY from window global object (injected by Livewire from DB)
  useEffect(() => {
    localStorage.removeItem('bengkel-calendar-events');
    const initial = (window as any).BengkelCalendarInitialEvents;
    if (initial && Array.isArray(initial)) {
      setEvents(initial);
    }
  }, []);

  // Upsert by date: jika sudah ada event di tanggal yang sama, update; jika belum, buat baru
  // id selalu sama dengan date (date sebagai natural identifier)
  const addEvent = (event: Omit<UserEvent, 'id'>): UserEvent => {
    let resultEvent: UserEvent;

    setEvents((prev) => {
      const existing = prev.find((e) => e.date === event.date);

      if (existing) {
        // Update event yang sudah ada di tanggal ini
        const updated: UserEvent = { ...existing, ...event };
        resultEvent = updated;
        window.dispatchEvent(new CustomEvent('bengkel-calendar-update', { detail: updated }));
        return prev.map((e) => (e.date === event.date ? updated : e));
      } else {
        // Buat event baru — id = date sebagai natural key
        const newEvent: UserEvent = { ...event, id: event.date };
        resultEvent = newEvent;
        window.dispatchEvent(new CustomEvent('bengkel-calendar-add', { detail: newEvent }));
        return [...prev, newEvent];
      }
    });

    return resultEvent!;
  };

  const deleteEvent = (id: string): void => {
    // id adalah date, hapus berdasarkan date
    setEvents((prev) => prev.filter((event) => event.id !== id));
    window.dispatchEvent(new CustomEvent('bengkel-calendar-delete', { detail: { id } }));
  };

  const getEventsByDate = (date: string): UserEvent[] => {
    return events.filter((event) => event.date === date);
  };

  const getEventsByMonth = (year: number, month: number): UserEvent[] => {
    const monthStr = String(month).padStart(2, '0');
    const yearStr = String(year);
    return events.filter((event) =>
      event.date.startsWith(`${yearStr}-${monthStr}`)
    );
  };

  return {
    events,
    addEvent,
    deleteEvent,
    getEventsByDate,
    getEventsByMonth,
  };
}
