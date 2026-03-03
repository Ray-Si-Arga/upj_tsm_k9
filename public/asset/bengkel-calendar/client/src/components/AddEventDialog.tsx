import { useState } from 'react';
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
  const charCount = description.length;

  const limitTo45Chars = (value: string): string => value.slice(0, 45);

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
      description: limitTo45Chars(description).trim() || undefined,
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
      <DialogContent showCloseButton={false} className="sm:max-w-[400px] overflow-hidden p-0 z-[1200]">
        <DialogHeader>
          <DialogTitle className="px-6 pt-6">Jadwal Bengkel</DialogTitle>
          <DialogDescription className="px-6">
            {selectedDate ? formatDate(selectedDate) : 'Pilih tanggal terlebih dahulu'}
          </DialogDescription>
        </DialogHeader>

        <form onSubmit={handleSubmit} className="space-y-6 px-6 pb-6">
          {/* Radio Is Closed */}
          <div className="space-y-4">
            <Label className="text-base">Bengkel Tutup?</Label>
            <RadioGroup
              value={isClosed}
              onValueChange={(val) => setIsClosed(val as 'yes' | 'no')}
              className="flex gap-6"
            >
              <div className="flex items-center space-x-2">
                <RadioGroupItem
                  value="yes"
                  id="closed-yes"
                  className="border-red-600 text-white data-[state=checked]:bg-red-600 data-[state=checked]:border-red-600"
                />
                <Label htmlFor="closed-yes" className="text-black font-medium cursor-pointer relative top-[1px]">Ya</Label>
              </div>
              <div className="flex items-center space-x-2">
                <RadioGroupItem
                  value="no"
                  id="closed-no"
                  className="border-red-600 text-white data-[state=checked]:bg-red-600 data-[state=checked]:border-red-600"
                />
                <Label htmlFor="closed-no" className="text-black font-medium cursor-pointer relative top-[1px]">Tidak</Label>
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
              onChange={(e) => setDescription(limitTo45Chars(e.target.value))}
              maxLength={45}
              wrap="soft"
              className="field-sizing-fixed resize-none [overflow-wrap:anywhere]"
              rows={3}
            />
            <div className="flex items-center justify-between">
              <p className="text-xs text-slate-500">Maksimal 45 karakter.</p>
              <p className="text-xs text-slate-500">{charCount}/45 karakter</p>
            </div>
          </div>

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
              className="bg-red-600 hover:bg-red-700"
            >
              Simpan
            </Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  );
}
