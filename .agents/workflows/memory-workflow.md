---
description: Workflow ini dirancang untuk membuat IDE Agent AI memiliki persistent memory. Tujuan utama workflow ini adalah menjadikan agent stateful, konsisten terhadap keputusan sebelumnya, serta mampu berkembang seperti developer manusia yang mengingat histori
---

Memory Workflow

## Lokasi Penyimpanan

```
/Reminiscence/Memory.md
```

Struktur direktori:

```
ProjectRoot/
├── .agent/
├── reminiscence/
│   └── Memory.md
└── main.py
```

---

# 1. Startup Phase

Tujuan: memastikan memory tersedia dan siap digunakan.

## Langkah

1. Cek apakah folder `Reminiscence` ada.
2. Jika tidak ada, buat folder.
3. Cek apakah file `Memory.md` ada.
4. Jika tidak ada, buat file dengan struktur default.
5. Load seluruh isi `Memory.md` ke dalam konteks agent.

## Struktur Default Memory.md

```markdown
# AI Reminiscence Memory

## Project Identity
- Nama Project:
- Tujuan:

## Architecture Decisions
-

## Coding Standards
-

## Plan History
-

## Task History
-

## Known Bugs
-

## Improvements
-
```

---

# 2. Pre-Task Execution Phase

Tujuan: menggunakan memory sebelum menjalankan task baru.

## Langkah

1. Baca seluruh isi `Memory.md`.
2. Ekstrak bagian penting:

   * Architecture Decisions
   * Coding Standards
   * Plan History
   * Known Bugs
3. Inject memory ke prompt sebelum memproses task user.

## Template Prompt Internal

```
Gunakan konteks berikut sebelum mengerjakan task:

[Isi Memory.md]

Sekarang kerjakan task berikut:
[Task User]
```

---

# 3. Task Execution Phase

Tujuan: menjalankan plan atau task sesuai permintaan user.

## Langkah

1. Generate plan (jika diperlukan).
2. Eksekusi plan.
3. Simpan hasil eksekusi (success, error, perubahan arsitektur).
4. Kumpulkan informasi yang relevan untuk disimpan ke memory.

---

# 4. Post-Task Memory Update Phase

Tujuan: memperbarui memory secara terstruktur.

## Aturan Update

1. Jangan overwrite seluruh file.
2. Hanya tambahkan atau perbarui section tertentu.
3. Gunakan timestamp atau tanggal.
4. Simpan secara ringkas.
5. Hindari duplikasi informasi.

## Contoh Update

```markdown
## Task History

### 2026-03-05
- Menambahkan JWT authentication
- Menggunakan library firebase/php-jwt
- Membuat middleware auth

## Architecture Decisions
- Menggunakan JWT untuk stateless authentication

## Known Bugs
- Token belum memiliki sistem refresh
```

---

# 5. Memory Locking Mechanism (Opsional)

Tujuan: mencegah race condition pada multi-agent.

## File Lock

```
/Reminiscence/Memory.lock
```

## Workflow

1. Sebelum menulis memory, cek apakah `Memory.lock` ada.
2. Jika ada, tunggu hingga lock dilepas.
3. Jika tidak ada, buat `Memory.lock`.
4. Lakukan update pada `Memory.md`.
5. Hapus `Memory.lock`.

---

# 6. Memory Summarization Phase

Tujuan: menjaga ukuran memory tetap efisien.

## Trigger

* Jika Memory.md melebihi batas tertentu (misalnya 1000 baris).
* Jika konteks terlalu panjang untuk dimasukkan ke LLM.

## Langkah

1. Baca seluruh Memory.md.
2. Ringkas Task History lama.
3. Pindahkan ringkasan ke section Archive.

## Contoh

```markdown
## Archived Summary
- Fase awal project fokus pada authentication dan routing.
- Menggunakan MVC native PHP.
- Migrasi ke JWT pada fase kedua.
```

4. Hapus detail lama yang tidak penting.

---

# 7. Multi-Agent Responsibility

Jika menggunakan arsitektur multi-agent:

```
Planner Agent
Coder Agent
Reviewer Agent
Memory Agent
```

## Tanggung Jawab Memory Agent

* Read memory
* Write memory
* Update section tertentu
* Summarize memory
* Handle locking
* Validasi format markdown

---

# 8. Full System Flow

```
START
  ↓
Startup Phase (Load Memory)
  ↓
User Request
  ↓
Pre-Task Memory Injection
  ↓
Plan Generation
  ↓
Task Execution
  ↓
Post-Task Analysis
  ↓
Update Memory.md
  ↓
END
```

---

# 9. Best Practices

1. Simpan memory dalam format markdown terstruktur.
2. Pisahkan section dengan heading konsisten.
3. Hindari menyimpan log mentah terlalu panjang.
4. Simpan hanya informasi yang berdampak pada keputusan arsitektur.
5. Gunakan summarization untuk menjaga efisiensi konteks.

---
