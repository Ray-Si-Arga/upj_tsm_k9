import { useState, useEffect } from 'react';

export interface UserEvent {
  id: string;
  date: string;
  title: string;
  description?: string;
  color: string;
  startTime?: string;
  endTime?: string;
  isClosed?: boolean;
}

const STORAGE_KEY = 'bengkel-calendar-events';

export function useUserEvents() {
  const [events, setEvents] = useState<UserEvent[]>([]);
  const [isLoaded, setIsLoaded] = useState(false);

  // Load events from window global object or localStorage on mount
  useEffect(() => {
    const initial = (window as any).BengkelCalendarInitialEvents;
    if (initial && Array.isArray(initial)) {
      setEvents(initial);
    } else {
      const stored = localStorage.getItem(STORAGE_KEY);
      if (stored) {
        try {
          setEvents(JSON.parse(stored));
        } catch (error) {
          console.error('Failed to parse stored events:', error);
        }
      }
    }
    setIsLoaded(true);
  }, []);

  // Save events to localStorage whenever they change
  useEffect(() => {
    if (isLoaded) {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(events));
    }
  }, [events, isLoaded]);

  const addEvent = (event: Omit<UserEvent, 'id'>): UserEvent => {
    const newEvent: UserEvent = {
      ...event,
      id: Date.now().toString(),
    };
    setEvents((prev) => [...prev, newEvent]);
    window.dispatchEvent(new CustomEvent('bengkel-calendar-add', { detail: newEvent }));
    return newEvent;
  };

  const updateEvent = (id: string, updates: Partial<UserEvent>): void => {
    setEvents((prev) => {
      const newEvents = prev.map((event) => (event.id === id ? { ...event, ...updates } : event));
      const updatedEvent = newEvents.find((event) => event.id === id);
      if (updatedEvent) {
        window.dispatchEvent(new CustomEvent('bengkel-calendar-update', { detail: updatedEvent }));
      }
      return newEvents;
    });
  };

  const deleteEvent = (id: string): void => {
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
    updateEvent,
    deleteEvent,
    getEventsByDate,
    getEventsByMonth,
    isLoaded,
  };
}
