import { useState, useEffect } from 'react';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Checkbox } from '@/components/ui/checkbox';
import type { UserEvent } from '@/hooks/useUserEvents';

interface AddEventDialogProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  selectedDate: string | null;
  onAddEvent: (event: Omit<UserEvent, 'id'>) => void;
  onDeleteEvent?: (id: string) => void;
  existingEvent?: UserEvent | null;
}

export default function AddEventDialog({
  open,
  onOpenChange,
  selectedDate,
  onAddEvent,
  onDeleteEvent,
  existingEvent,
}: AddEventDialogProps) {
  // 'closed' | 'operational' | null — hanya satu boleh aktif
  const [selected, setSelected] = useState<'closed' | 'operational' | null>(null);
  const [description, setDescription] = useState('');
  const charCount = description.length;

  const limitTo45Chars = (value: string): string => value.slice(0, 45);

  // Pre-fill saat dialog dibuka
  useEffect(() => {
    if (open && existingEvent) {
      if (existingEvent.isClosed) setSelected('closed');
      else if (existingEvent.isOperational) setSelected('operational');
      else setSelected(null);
      setDescription(existingEvent.description || '');
    } else if (open && !existingEvent) {
      setSelected(null);
      setDescription('');
    }
  }, [open, existingEvent]);

  const handleToggle = (type: 'closed' | 'operational') => {
    setSelected((prev) => {
      // Toggle: jika sudah aktif, uncheck
      if (prev === type) return null;
      // Ganti ke pilihan lain, reset description jika pindah ke closed
      if (type === 'closed') setDescription('');
      return type;
    });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (!selectedDate) return;

    // Jika tidak ada yang dipilih tapi ada existing event → hapus event (badge hilang)
    if (selected === null) {
      if (existingEvent && onDeleteEvent) {
        onDeleteEvent(existingEvent.id);
        onOpenChange(false);
      }
      return;
    }

    const isClosed = selected === 'closed';
    const isOperational = selected === 'operational';
    const title = isClosed ? 'Bengkel Tutup' : 'Catatan Operasional';

    onAddEvent({
      date: selectedDate,
      title,
      description: limitTo45Chars(description).trim() || undefined,
      isClosed,
      isOperational,
    });

    // Reset form & tutup
    setSelected(null);
    setDescription('');
    onOpenChange(false);
  };

  const formatDate = (dateStr: string): string => {
    const date = new Date(dateStr + 'T00:00:00');
    return date.toLocaleString('id-ID', {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    });
  };

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent showCloseButton={false} className="sm:max-w-[400px] overflow-hidden p-0 z-1200">
        <DialogHeader>
          <DialogTitle className="px-6 pt-6">Jadwal Bengkel</DialogTitle>
          <DialogDescription className="px-6">
            {selectedDate ? formatDate(selectedDate) : 'Pilih tanggal terlebih dahulu'}
          </DialogDescription>
        </DialogHeader>

        <form onSubmit={handleSubmit} className="space-y-4 px-6 pb-6">

          {/* Checkbox: Bengkel Tutup */}
          <div className="flex items-center gap-3 pt-2">
            <Checkbox
              id="is-closed"
              checked={selected === 'closed'}
              onCheckedChange={() => handleToggle('closed')}
              className="border-red-500 data-[state=checked]:bg-red-600 data-[state=checked]:border-red-600 size-5"
            />
            <Label
              htmlFor="is-closed"
              className="text-sm font-medium text-slate-800 cursor-pointer select-none"
            >
              Bengkel Tutup
            </Label>
          </div>

          {/* Checkbox: Catatan Operasional */}
          <div className="space-y-3">
            <div className="flex items-center gap-3">
              <Checkbox
                id="is-operational"
                checked={selected === 'operational'}
                onCheckedChange={() => handleToggle('operational')}
                className="border-blue-500 data-[state=checked]:bg-blue-600 data-[state=checked]:border-blue-600 size-5"
              />
              <Label
                htmlFor="is-operational"
                className="text-sm font-medium text-slate-800 cursor-pointer select-none"
              >
                Catatan Operasional
              </Label>
            </div>

            {/* Textarea muncul saat salah satu dipilih */}
            {selected !== null && (
              <div className="space-y-1 pl-8">
                <Textarea
                  id="description"
                  placeholder={
                    selected === 'closed'
                      ? 'Contoh: Libur Lebaran, atau Sedang Direnovasi'
                      : 'Contoh: Buka setengah hari, atau kondisi khusus lainnya'
                  }
                  value={description}
                  onChange={(e) => setDescription(limitTo45Chars(e.target.value))}
                  maxLength={45}
                  wrap="soft"
                  className="field-sizing-fixed resize-none wrap-anywhere"
                  rows={3}
                />
                <div className="flex items-center justify-between">
                  <p className="text-xs text-slate-500">Maksimal 45 karakter.</p>
                  <p className="text-xs text-slate-500">{charCount}/45 karakter</p>
                </div>
              </div>
            )}
          </div>

          {/* Hint situasional */}
          {selected === null && !existingEvent && (
            <p className="text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-md px-3 py-2">
              Pilih salah satu opsi di atas untuk menyimpan jadwal.
            </p>
          )}
          {selected === null && existingEvent && (
            <p className="text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-md px-3 py-2">
              Semua opsi dihapus. Klik Simpan untuk menghapus jadwal di tanggal ini.
            </p>
          )}

          {/* Buttons */}
          <DialogFooter className="-mx-6 -mb-6 mt-2 bg-gray-50 px-6 py-4">
            <Button
              type="button"
              variant="outline"
              onClick={() => onOpenChange(false)}
            >
              Batal
            </Button>
            <Button
              type="submit"
              disabled={selected === null && !existingEvent}
              className="bg-red-600 hover:bg-red-700 disabled:opacity-50"
            >
              Simpan
            </Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  );
}
