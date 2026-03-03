import { useMemo } from 'react';
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

const getHolidayColor = (holidayName: string): string => {
  // Religious holidays - gold
  if (
    holidayName.includes('Isra') ||
    holidayName.includes('Mikraj') ||
    holidayName.includes('Idul') ||
    holidayName.includes('Maulid') ||
    holidayName.includes('Muharam') ||
    holidayName.includes('Kristus') ||
    holidayName.includes('Paskah') ||
    holidayName.includes('Waisak')
  ) {
    return 'bg-amber-100 text-amber-900';
  }
  // National celebrations - red
  if (
    holidayName.includes('Kemerdekaan') ||
    holidayName.includes('Pancasila') ||
    holidayName.includes('Tahun Baru')
  ) {
    return 'bg-red-100 text-red-900';
  }
  // Cultural festivals - orange
  if (holidayName.includes('Nyepi') || holidayName.includes('Imlek')) {
    return 'bg-orange-100 text-orange-900';
  }
  // Other holidays - blue
  return 'bg-blue-100 text-blue-900';
};

export default function HolidayCalendar({
  currentDate,
  holidays,
  selectedDate,
  onDateSelect,
  loading,
  userEvents = [],
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
            const isToday =
              dateString === formatDateString(new Date());
            const isSelected = selectedDate === dateString;
            const dayHolidays = holidayMap.get(dateString) || [];
            const dayUserEvents = userEvents.filter((e: any) => e.date === dateString);

            return (
              <button
                key={dateString}
                onClick={() => onDateSelect(dateString)}
                className={`
                  aspect-square rounded-lg p-2 text-sm font-medium
                  transition-all duration-200 relative
                  flex flex-col items-center justify-center
                  ${isCurrentMonth ? 'text-slate-900' : 'text-slate-300'}
                  ${isToday ? 'ring-2 ring-red-500 bg-red-50' : ''}
                  ${isSelected ? 'bg-red-100 ring-2 ring-red-500 shadow-md' : isCurrentMonth ? 'hover:bg-slate-100 hover:shadow-sm' : 'bg-slate-50'}
                  ${!isCurrentMonth ? 'bg-slate-50' : 'bg-white'}
                  cursor-pointer
                `}
              >
                <span className="text-xs sm:text-sm">{day.getDate()}</span>
                <div className="absolute bottom-1 flex gap-1">
                  {dayHolidays.slice(0, 1).map((holiday, idx) => (
                    <div
                      key={`holiday-${idx}`}
                      className={`w-1.5 h-1.5 rounded-full ${
                        getHolidayColor(holiday.name).split(' ')[0]
                      }`}
                    />
                  ))}
                  {dayUserEvents.slice(0, 1).map((event: any, idx: number) => (
                    <div
                      key={`event-${idx}`}
                      className="w-1.5 h-1.5 rounded-full"
                      style={{ backgroundColor: event.color }}
                    />
                  ))}
                </div>
              </button>
            );
          })}
        </div>
      )}

      {/* Legend */}
      <div className="mt-6 pt-4 border-t border-slate-200">
        <p className="text-xs font-semibold text-slate-600 mb-3">Jenis Libur:</p>
        <div className="grid grid-cols-2 gap-3 text-xs">
          <div className="flex items-center gap-2">
            <div className="w-3 h-3 rounded-full bg-amber-300" />
            <span className="text-slate-600">Hari Raya</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="w-3 h-3 rounded-full bg-red-400" />
            <span className="text-slate-600">Nasional</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="w-3 h-3 rounded-full bg-orange-400" />
            <span className="text-slate-600">Budaya</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="w-3 h-3 rounded-full bg-blue-400" />
            <span className="text-slate-600">Lainnya</span>
          </div>
        </div>
      </div>
    </div>
  );
}
