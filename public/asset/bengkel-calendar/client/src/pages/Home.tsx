import { useState, useEffect } from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import HolidayCalendar from '@/components/HolidayCalendar';
import HolidayList from '@/components/HolidayList';
import AddEventDialog from '@/components/AddEventDialog';
import EventDetailsDialog from '@/components/EventDetailsDialog';
import { useUserEvents } from '@/hooks/useUserEvents';

/**
 * Home Page - Indonesian Holiday Calendar
 * 
 * Design Philosophy: Modern Minimalism with Cultural Warmth
 * - Clean typography and generous whitespace
 * - Holiday colors reflect cultural significance
 * - Responsive and accessible interface
 */

interface Holiday {
  date: string;
  name: string;
}

export default function Home() {
  const [currentDate, setCurrentDate] = useState(new Date());
  const [holidays, setHolidays] = useState<Holiday[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedDate, setSelectedDate] = useState<string | null>(null);
  const [isAddEventOpen, setIsAddEventOpen] = useState(false);
  const [selectedEventDetail, setSelectedEventDetail] = useState<any>(null);
  const { events, addEvent, deleteEvent } = useUserEvents();

  // Fetch holidays for the current year
  useEffect(() => {
    const fetchHolidays = async () => {
      try {
        setLoading(true);
        const year = currentDate.getFullYear();
        const response = await fetch(`https://libur.deno.dev/api?year=${year}`);
        const data = await response.json();
        setHolidays(data);
      } catch (error) {
        console.error('Failed to fetch holidays:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchHolidays();
  }, [currentDate]);

  const handlePrevMonth = () => {
    setCurrentDate(new Date(currentDate.getFullYear(), currentDate.getMonth() - 1));
  };

  const handleNextMonth = () => {
    setCurrentDate(new Date(currentDate.getFullYear(), currentDate.getMonth() + 1));
  };

  const handleToday = () => {
    setCurrentDate(new Date());
  };

  const handleDateSelect = (date: string) => {
    setSelectedDate(date);
    
    // Check if user event already exists on this date
    const existingEvent = events.find((e) => e.date === date);
    if (existingEvent) {
      // If exists, show details
      setSelectedEventDetail(existingEvent);
    } else {
      // If none, open add event form
      setIsAddEventOpen(true);
    }
  };

  const monthName = currentDate.toLocaleString('id-ID', { month: 'long', year: 'numeric' });

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50">

      <main className="container max-w-6xl mx-auto px-4 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Calendar Section */}
          <div className="lg:col-span-2">
            <Card className="p-6 shadow-md">
              {/* Month Navigation */}
              <div className="flex items-center justify-between mb-6">
                <div>
                  <h2 className="text-2xl font-bold text-slate-900 capitalize">
                    {monthName}
                  </h2>
                </div>
                <div className="flex gap-2">
                  <Button
                    variant="outline"
                    size="sm"
                    onClick={handlePrevMonth}
                    className="hover:bg-slate-100"
                  >
                    <ChevronLeft className="w-4 h-4" />
                  </Button>
                  <Button
                    variant="outline"
                    size="sm"
                    onClick={handleToday}
                    className="hover:bg-slate-100"
                  >
                    Hari Ini
                  </Button>
                  <Button
                    variant="outline"
                    size="sm"
                    onClick={handleNextMonth}
                    className="hover:bg-slate-100"
                  >
                    <ChevronRight className="w-4 h-4" />
                  </Button>
                </div>
              </div>

              {/* Calendar Grid */}
              <HolidayCalendar
                currentDate={currentDate}
                holidays={holidays}
                selectedDate={selectedDate}
                onDateSelect={handleDateSelect}
                loading={loading}
                userEvents={events}
              />
            </Card>
          </div>

          {/* Holiday List Sidebar */}
          <div className="lg:col-span-1 space-y-4">
            <HolidayList
              holidays={holidays}
              currentDate={currentDate}
              selectedDate={selectedDate}
              onDateSelect={setSelectedDate}
              loading={loading}
              userEvents={events}
              onDeleteEvent={deleteEvent}
              onEventClick={setSelectedEventDetail}
            />
          </div>
        </div>
      </main>

      {/* Modal Dialog for Adding Event */}
      <AddEventDialog
        open={isAddEventOpen}
        onOpenChange={setIsAddEventOpen}
        selectedDate={selectedDate}
        onAddEvent={addEvent}
      />

      {/* Modal Dialog for Event Details */}
      <EventDetailsDialog 
        event={selectedEventDetail} 
        onClose={() => setSelectedEventDetail(null)} 
      />

      {/* Hidden Data Output for Backend Form Submission (Laravel/PHP/dll) */}
      <input 
        type="hidden" 
        id="calendar-events-output" 
        name="calendar_events" 
        value={JSON.stringify(events)} 
      />
    </div>
  );
}
