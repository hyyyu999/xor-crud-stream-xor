<?php
include "config.php";
include "xor_functions.php";

// NOTE: For demo purposes the key is stored here.
// In production, don't hardcode keys; use environment or secure vault.
$key = "sekolah123"; // kunci XOR default

// CREATE
if (isset($_POST['create'])) {
    $plain = $_POST['plain'];
    $encrypted = xor_encrypt($plain, $key);

    $stmt = mysqli_prepare($conn, "INSERT INTO messages (name, encrypted_text) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $name_in, $encrypted_in);
    $name_in = isset($_POST['name']) ? $_POST['name'] : 'Anonymous';
    $encrypted_in = $encrypted;
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}

// UPDATE
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $plain = $_POST['plain'];
    $name_up = $_POST['name'];
    $encrypted = xor_encrypt($plain, $key);

    $stmt = mysqli_prepare($conn, "UPDATE messages SET name=?, encrypted_text=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $name_up, $encrypted, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = mysqli_prepare($conn, "DELETE FROM messages WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: index.php");
    exit;
}

// Fetch data
$data = mysqli_query($conn, "SELECT * FROM messages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CRUD XOR Encryption (XAMPP)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg,#6a11cb,#2575fc); color: #fff; min-height: 100vh; }
        .card { border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
        textarea, input { border-radius: 6px; }
        .container { padding-top: 30px; padding-bottom: 30px; }
        .table-light td, .table-light th { background: rgba(255,255,255,0.95); color:#222; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3>XOR Stream + CRUD (XAMPP)</h3>
                <p class="text-muted">Demo sederhana menyimpan pesan terenkripsi (XOR + Base64) ke MySQL.</p>

                <form method="POST" class="mb-3">
                    <div class="mb-2">
                        <label class="form-label text-dark">Nama</label>
                        <input name="name" class="form-control" placeholder="Nama (opsional)">
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-dark">Pesan Asli</label>
                        <textarea name="plain" class="form-control" rows="3" placeholder="Ketik pesan..."></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button name="create" class="btn btn-primary">Encrypt & Save</button>
                    </div>
                </form>

                <hr>
                <h5>Data Tersimpan</h5>
                <table class="table table-light table-striped">
                    <thead><tr><th>ID</th><th>Nama</th><th>Encrypted</th><th>Decrypted</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php while ($d = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= htmlspecialchars($d['id']) ?></td>
                            <td><?= htmlspecialchars($d['name']) ?></td>
                            <td style="max-width:300px;word-wrap:break-word;"><?= htmlspecialchars($d['encrypted_text']) ?></td>
                            <td><?= htmlspecialchars(xor_decrypt($d['encrypted_text'], $key)) ?></td>
                            <td>
                                <a class="btn btn-sm btn-success" href="index.php?edit=<?= $d['id'] ?>">Edit</a>
                                <a class="btn btn-sm btn-danger" href="index.php?delete=<?= $d['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <?php
                if (isset($_GET['edit'])):
                    $id = intval($_GET['edit']);
                    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM messages WHERE id=$id"));
                ?>
                <hr>
                <h5>Edit ID <?= $id ?></h5>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <div class="mb-2">
                        <label class="form-label text-dark">Nama</label>
                        <input name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-dark">Pesan Asli</label>
                        <textarea name="plain" class="form-control" rows="3"><?= htmlspecialchars(xor_decrypt($row['encrypted_text'], $key)) ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button name="update" class="btn btn-primary">Update</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <div class="text-center mt-3 text-white-50"><small>Demo XOR stream encryption — educational only.</small></div>
    <div class="text-center mt-2">
        <img src="screenshot.png" style="max-width:300px;border-radius:8px;margin-top:12px;">
    </div>
</div>
</body>
</html>
