import { useMemo } from 'react';
import { Card } from '@/components/ui/card';
import { Loader2, Calendar } from 'lucide-react';

interface Holiday {
  date: string;
  name: string;
}

interface HolidayListProps {
  holidays: Holiday[];
  currentDate: Date;
  selectedDate: string | null;
  onDateSelect: (date: string) => void;
  loading: boolean;
  userEvents?: any[];
  onDeleteEvent?: (id: string) => void;
  onEventClick?: (event: any) => void;
}

/**
 * HolidayList Component
 * 
 * Displays a list of holidays for the current month.
 * Design: Card-based layout with holiday type indicators
 */

const getHolidayType = (holidayName: string): { label: string; color: string } => {
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
    return { label: 'Hari Raya', color: 'bg-amber-100 text-amber-800' };
  }
  if (
    holidayName.includes('Kemerdekaan') ||
    holidayName.includes('Pancasila') ||
    holidayName.includes('Tahun Baru')
  ) {
    return { label: 'Nasional', color: 'bg-red-100 text-red-800' };
  }
  if (holidayName.includes('Nyepi') || holidayName.includes('Imlek')) {
    return { label: 'Budaya', color: 'bg-orange-100 text-orange-800' };
  }
  return { label: 'Libur', color: 'bg-blue-100 text-blue-800' };
};

export default function HolidayList({
  holidays,
  currentDate,
  selectedDate,
  onDateSelect,
  loading,
  userEvents = [],
  onDeleteEvent,
  onEventClick,
}: HolidayListProps) {
  const monthHolidays = useMemo(() => {
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');

    return holidays
      .filter((holiday) => holiday.date.startsWith(`${year}-${month}`))
      .sort((a, b) => a.date.localeCompare(b.date));
  }, [holidays, currentDate]);

  const formatDate = (dateString: string): string => {
    const date = new Date(dateString + 'T00:00:00');
    return date.toLocaleString('id-ID', {
      weekday: 'short',
      day: 'numeric',
      month: 'short',
    });
  };

  return (
    <div className="space-y-4">
      <div className="flex items-center gap-2 mb-4">
        <Calendar className="w-5 h-5 text-red-600" />
        <h3 className="text-lg font-semibold text-slate-900">
          Libur Bulan Ini
        </h3>
      </div>

      {loading ? (
        <div className="flex items-center justify-center py-8">
          <Loader2 className="w-5 h-5 animate-spin text-red-600" />
        </div>
      ) : monthHolidays.length === 0 ? (
        <Card className="p-4 bg-slate-50 border-slate-200">
          <p className="text-sm text-slate-600 text-center">
            Tidak ada hari libur bulan ini
          </p>
        </Card>
      ) : (
        <div className="space-y-3">
          {monthHolidays.map((holiday) => {
            const holidayType = getHolidayType(holiday.name);
            const isSelected = selectedDate === holiday.date;

            return (
              <Card
                key={holiday.date}
                onClick={() => onDateSelect(holiday.date)}
                className={`
                  p-4 cursor-pointer transition-all duration-200 hover:shadow-md
                  ${
                    isSelected
                      ? 'bg-red-50 border-red-300 ring-2 ring-red-200 shadow-md'
                      : 'hover:bg-slate-50 hover:border-slate-300'
                  }
                `}
              >
                <div className="space-y-2">
                  <div className="flex items-start justify-between gap-2">
                    <div className="flex-1 min-w-0">
                      <p className="font-semibold text-slate-900 text-sm leading-tight">
                        {holiday.name}
                      </p>
                    </div>
                    <span
                      className={`
                        px-2 py-1 rounded text-xs font-medium whitespace-nowrap
                        ${holidayType.color}
                      `}
                    >
                      {holidayType.label}
                    </span>
                  </div>
                  <p className="text-xs text-slate-500">
                    {formatDate(holiday.date)}
                  </p>
                </div>
              </Card>
            );
          })}
        </div>
      )}

      {/* User Events Section */}
      {userEvents.length > 0 && (
        <div className="mt-6 pt-4 border-t border-slate-200">
          <p className="text-xs font-semibold text-slate-600 mb-3 uppercase">Event</p>
          <div className="space-y-2">
            {[...userEvents]
              .sort((a: any, b: any) => a.date.localeCompare(b.date))
              .map((event: any) => (
                <Card
                  key={event.id}
                  onClick={() => onEventClick && onEventClick(event)}
                  className="p-3 hover:shadow-md transition-all cursor-pointer"
                  style={{
                    borderLeftWidth: '4px',
                    borderLeftColor: event.color,
                  }}
                >
                  <div className="flex items-start justify-between gap-2">
                    <div className="flex-1 min-w-0">
                      <p className="font-semibold text-slate-900 text-sm">
                        {event.title}
                      </p>
                      <p className="text-xs text-slate-500 mt-1 flex flex-wrap gap-1 items-center">
                        <span className="font-medium bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">
                          {formatDate(event.date)}
                        </span>
                        {event.startTime && (
                          <span>
                            • {event.startTime}
                            {event.endTime && ` - ${event.endTime}`}
                          </span>
                        )}
                      </p>
                    </div>
                    {onDeleteEvent && (
                      <button
                        onClick={(e) => {
                          e.stopPropagation();
                          onDeleteEvent(event.id);
                        }}
                        className="text-red-600 hover:text-red-700 text-sm"
                      >
                        Hapus
                      </button>
                    )}
                  </div>
                </Card>
              ))}
          </div>
        </div>
      )}
    </div>
  );
}
