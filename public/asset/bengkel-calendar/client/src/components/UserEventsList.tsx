import { Trash2, Clock } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import type { UserEvent } from '@/hooks/useUserEvents';

interface UserEventsListProps {
  events: UserEvent[];
  onDeleteEvent: (id: string) => void;
}

export default function UserEventsList({
  events,
  onDeleteEvent,
}: UserEventsListProps) {
  if (events.length === 0) {
    return (
      <Card className="p-4 bg-slate-50 border-slate-200">
        <p className="text-sm text-slate-600 text-center">
          Belum ada event yang dibuat
        </p>
      </Card>
    );
  }

  return (
    <div className="space-y-2">
      {events.map((event) => (
        <Card
          key={event.id}
          className="p-3 hover:shadow-md transition-all"
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
              {event.description && (
                <p className="text-xs text-slate-600 mt-1 line-clamp-2">
                  {event.description}
                </p>
              )}
              {event.startTime && (
                <div className="flex items-center gap-1 mt-2 text-xs text-slate-500">
                  <Clock className="w-3 h-3" />
                  <span>
                    {event.startTime}
                    {event.endTime && ` - ${event.endTime}`}
                  </span>
                </div>
              )}
            </div>
            <Button
              variant="ghost"
              size="sm"
              onClick={() => onDeleteEvent(event.id)}
              className="text-red-600 hover:text-red-700 hover:bg-red-50"
            >
              <Trash2 className="w-4 h-4" />
            </Button>
          </div>
        </Card>
      ))}
    </div>
  );
}
