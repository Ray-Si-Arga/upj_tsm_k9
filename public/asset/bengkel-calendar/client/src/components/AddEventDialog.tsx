import { useState } from 'react';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import type { UserEvent } from '@/hooks/useUserEvents';

interface AddEventDialogProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  selectedDate: string | null;
  onAddEvent: (event: Omit<UserEvent, 'id'>) => void;
}

export default function AddEventDialog({
  open,
  onOpenChange,
  selectedDate,
  onAddEvent,
}: AddEventDialogProps) {
  const [isClosed, setIsClosed] = useState<'yes' | 'no'>('yes');
  const [description, setDescription] = useState('');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (!selectedDate) {
      return;
    }

    const title = isClosed === 'yes' ? 'Bengkel Tutup' : 'Catatan Operasional';
    const color = isClosed === 'yes' ? '#ef4444' : '#3b82f6'; // Merah tutup, Biru buka

    onAddEvent({
      date: selectedDate,
      title,
      description: description.trim() || undefined,
      color,
      isClosed: isClosed === 'yes',
    });

    // Reset form
    setIsClosed('yes');
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
      <DialogContent className="sm:max-w-[400px]">
        <DialogHeader>
          <DialogTitle>Jadwal Bengkel</DialogTitle>
          <DialogDescription>
            {selectedDate ? formatDate(selectedDate) : 'Pilih tanggal terlebih dahulu'}
          </DialogDescription>
        </DialogHeader>

        <form onSubmit={handleSubmit} className="space-y-6 py-2">
          {/* Radio Is Closed */}
          <div className="space-y-4">
            <Label className="text-base">Bengkel Tutup?</Label>
            <RadioGroup
              value={isClosed}
              onValueChange={(val) => setIsClosed(val as 'yes' | 'no')}
              className="flex gap-6"
            >
              <div className="flex items-center space-x-2">
                <RadioGroupItem value="yes" id="closed-yes" />
                <Label htmlFor="closed-yes" className="text-red-600 font-medium cursor-pointer relative top-[1px]">Ya</Label>
              </div>
              <div className="flex items-center space-x-2">
                <RadioGroupItem value="no" id="closed-no" />
                <Label htmlFor="closed-no" className="text-blue-600 font-medium cursor-pointer relative top-[1px]">Tidak</Label>
              </div>
            </RadioGroup>
          </div>

          {/* Description */}
          <div className="space-y-2">
            <Label htmlFor="description">Deskripsi / Catatan</Label>
            <Textarea
              id="description"
              placeholder={isClosed === 'yes' ? "Contoh: Libur Lebaran, atau Sedang Direnovasi" : "Contoh: Buka setengah hari"}
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              rows={3}
            />
          </div>

          {/* Buttons */}
          <div className="flex gap-2 justify-end pt-2">
            <Button
              type="button"
              variant="outline"
              onClick={() => onOpenChange(false)}
            >
              Batal
            </Button>
            <Button
              type="submit"
              className={isClosed === 'yes' ? "bg-red-600 hover:bg-red-700" : "bg-blue-600 hover:bg-blue-700"}
            >
              Simpan
            </Button>
          </div>
        </form>
      </DialogContent>
    </Dialog>
  );
}
