import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';

interface EventDetailsDialogProps {
  event: any | null;
  onClose: () => void;
}

export default function EventDetailsDialog({ event, onClose }: EventDetailsDialogProps) {
  return (
    <Dialog open={!!event} onOpenChange={(open) => !open && onClose()}>
      <DialogContent className="sm:max-w-md">
        <DialogHeader>
          <DialogTitle>Detail Event</DialogTitle>
        </DialogHeader>
        {event && (
          <div className="space-y-4 py-4">
            <div className="flex items-center gap-3">
              <div 
                className="w-4 h-4 rounded-full" 
                style={{ backgroundColor: event.isClosed ? '#ef4444' : event.isOperational ? '#3b82f6' : '#94a3b8' }}
              />
              <h4 className="font-medium text-lg text-slate-900">{event.title}</h4>
            </div>
            
            <div className="text-sm text-slate-600 bg-slate-50 p-3 rounded-md">
              <p><strong>Tanggal:</strong> {event.date}</p>

              {event.description && (
                <p className="mt-2 text-slate-700">{event.description}</p>
              )}
              {(event.isClosed !== undefined || event.isOperational !== undefined) && (
                <div className="mt-3">
                  <span className={`px-2 py-1 text-xs font-semibold rounded-md ${
                    event.isClosed
                      ? 'bg-red-100 text-red-700'
                      : event.isOperational
                      ? 'bg-blue-100 text-blue-700'
                      : 'bg-slate-100 text-slate-600'
                  }`}>
                    Status: {event.isClosed ? 'Bengkel Tutup' : event.isOperational ? 'Catatan Operasional' : 'Tidak Ada Keterangan'}
                  </span>
                </div>
              )}
            </div>
          </div>
        )}
      </DialogContent>
    </Dialog>
  );
}
