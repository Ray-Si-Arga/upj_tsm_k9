import { useMemo } from 'react';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import { Loader2 } from 'lucide-react';

interface Holiday {
  date: string;
  name: string;
}

interface HolidayCalendarProps {
  currentDate: Date;
  holidays: Holiday[];
  selectedDate: string | null;
  onDateSelect: (date: string) => void;
  loading: boolean;
  userEvents?: any[];
}

/**
 * HolidayCalendar Component
 * 
 * Displays a calendar grid with holiday indicators.
 * Design: Clean grid layout with colored badges for holidays
 */

const WEEKDAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

interface UserEvent {
  id: string;
  date: string;
  title: string;
  description: string;
  status: string;
  isClosed: boolean;
  isOperational: boolean;
}



export default function HolidayCalendar({
  currentDate,
  holidays,
  selectedDate,
  onDateSelect,
  loading,
  userEvents = [] as UserEvent[],
}: HolidayCalendarProps) {
  const calendarDays = useMemo(() => {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    // First day of the month
    const firstDay = new Date(year, month, 1);
    // Last day of the month
    const lastDay = new Date(year, month + 1, 0);

    // Days to display from previous month
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());

    // Create array of dates
    const days: (Date | null)[] = [];
    const current = new Date(startDate);

    while (current <= lastDay || current.getDay() !== 0) {
      days.push(new Date(current));
      current.setDate(current.getDate() + 1);
    }

    return days;
  }, [currentDate]);

  const holidayMap = useMemo(() => {
    const map = new Map<string, Holiday[]>();
    holidays.forEach((holiday) => {
      if (!map.has(holiday.date)) {
        map.set(holiday.date, []);
      }
      map.get(holiday.date)!.push(holiday);
    });
    return map;
  }, [holidays]);

  const formatDateString = (date: Date): string => {
    // Menghindari timezone offset isue: get local year, month, date
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };

  return (
    <div className="space-y-6">
      {/* Weekday Headers */}
      <div className="grid grid-cols-7 gap-2 mb-6 pb-4 border-b border-slate-200">
        {WEEKDAYS.map((day) => (
          <div
            key={day}
            className="text-center font-semibold text-slate-700 text-sm py-3 uppercase tracking-wider"
          >
            {day}
          </div>
        ))}
      </div>

      {/* Calendar Grid */}
      {loading ? (
        <div className="flex items-center justify-center py-12">
          <Loader2 className="w-6 h-6 animate-spin text-red-600" />
        </div>
      ) : (
        <div className="grid grid-cols-7 gap-2">
          {calendarDays.map((day, index) => {
            if (!day) return <div key={`empty-${index}`} className="aspect-square" />;

            const dateString = formatDateString(day);
            const isCurrentMonth = day.getMonth() === currentDate.getMonth();
            const isToday = dateString === formatDateString(new Date());
            const isSelected = selectedDate === dateString;
            const dayHolidays = holidayMap.get(dateString) || [];
            const dayUserEvents = userEvents.filter((e) => e.date === dateString);
            const firstEvent = dayUserEvents[0];
            const isTutup = firstEvent?.isClosed === true;
            const isCatatan = firstEvent?.isOperational === true;

            return (
              <Tooltip>
                <TooltipTrigger asChild>
                  <button
                    key={dateString}
                    onClick={() => onDateSelect(dateString)}
                    className={`
                      aspect-square rounded-lg p-2 text-sm font-medium
                      transition-all duration-200 relative
                      flex flex-col items-center justify-center
                      ${isCurrentMonth ? 'text-slate-900' : 'text-slate-300'}
                      ${isToday ? 'ring-2 ring-red-500 bg-red-50' : ''}
                      ${isSelected ? 'bg-red-100 ring-2 ring-red-500 shadow-md' : isCurrentMonth && dayHolidays.length === 0 ? 'hover:bg-slate-100 hover:shadow-sm' : !isCurrentMonth ? 'bg-slate-50' : ''}
                      ${dayHolidays.length > 0 && isCurrentMonth && !isSelected && !isToday ? 'bg-red-500 text-white! hover:bg-red-700' : !isCurrentMonth ? 'bg-slate-50' : isSelected ? 'bg-red-100' : isToday ? 'bg-red-50' : 'bg-white'}
                      cursor-pointer
                    `}
                  >
                    {isTutup && (
                      <div className="absolute top-0 left-0 bg-red-600 text-white text-[10px] px-1.5 py-1 rounded-br-lg rounded-tl-lg z-10">
                        Tutup
                      </div>
                    )}
                    {!isTutup && isCatatan && (
                      <div className="absolute top-0 left-0 bg-blue-600 text-white text-[10px] px-1.5 py-1 rounded-br-lg rounded-tl-lg z-10">
                        Catatan
                      </div>
                    )}
                    <span className="text-xs sm:text-sm">{day.getDate()}</span>
                    <div className="absolute bottom-1 flex gap-1">
                      {dayUserEvents.slice(0, 1).map((event, idx) => (
                        <div
                          key={`event-${idx}`}
                          className="w-1.5 h-1.5 rounded-full"
                          style={{ backgroundColor: firstEvent?.isClosed ? '#ef4444' : '#3b82f6' }}
                        />
                      ))}
                    </div>
                  </button>
                </TooltipTrigger>
                {dayUserEvents.length > 0 && (
                  <TooltipContent className="bg-white p-2 rounded-md shadow-lg border border-gray-200 text-sm">
                    {dayUserEvents.map((event, idx) => (
                      <div key={idx} className="mb-1 last:mb-0">
                        <p className="font-semibold text-gray-900">{event.title}</p>
                        <p className="text-gray-700">Tanggal: {event.date}</p>
                        <p className="text-gray-700">Status: {event.status}</p>
                        {event.description && <p className="text-gray-700">{event.description}</p>}
                      </div>
                    ))}
                  </TooltipContent>
                )}
              </Tooltip>
            );
          })}
        </div>
      )}

      {/* Legend */}
      <div className="mt-6 pt-4 border-t border-slate-200">
        <p className="text-xs font-semibold text-slate-600 mb-3">Keterangan:</p>
        <div className="flex flex-wrap gap-4 text-xs">
          <div className="flex items-center gap-2">
            <div className="w-4 h-4 rounded bg-red-500" />
            <span className="text-slate-600">Hari Libur</span>
          </div>
        </div>
      </div>
    </div>
  );
}
