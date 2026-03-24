<?php
require_once('auth_check.php');
require_once('../config/db.php');

// Fetch pending KYC submissions
$stmt = $pdo->prepare("SELECT k.*, u.username, u.email FROM kyc k JOIN users u ON k.user_id = u.id WHERE k.status = 'pending' ORDER BY k.created_at DESC");
$stmt->execute();
$pendingKyc = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage KYC - Tenvault Admin</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-slate-50 dark:bg-navy-900 p-8 text-slate-700 dark:text-navy-100">
    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">KYC Verification Queue</h1>
            <a href="index.php" class="btn bg-slate-200 text-slate-700">Back to Dashboard</a>
        </header>

        <?php if (empty($pendingKyc)): ?>
            <div class="card p-12 text-center">
                <i class="fa fa-check-circle text-success text-5xl mb-4"></i>
                <p class="text-lg">No pending KYC submissions to review.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6">
                <?php foreach ($pendingKyc as $k): ?>
                    <div class="card p-6 flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold mb-2"><?= htmlspecialchars($k['username']) ?></h3>
                            <p class="text-sm mb-1">Email: <b><?= htmlspecialchars($k['email']) ?></b></p>
                            <p class="text-sm mb-1">ID Type: <b><?= htmlspecialchars($k['id_type']) ?></b></p>
                            <p class="text-sm mb-1">ID Number: <b><?= htmlspecialchars($k['id_number']) ?></b></p>
                            <p class="text-sm mb-4">Address: <?= htmlspecialchars($k['address_line'] . ', ' . $k['city'] . ', ' . $k['country']) ?></p>
                            
                            <div class="flex gap-2">
                                <form action="process_kyc.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $k['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= $k['user_id'] ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button class="btn bg-success text-white">Approve Verification</button>
                                </form>
                                <form action="process_kyc.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $k['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= $k['user_id'] ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <input type="text" name="reason" placeholder="Rejection reason..." class="form-input text-xs w-32 inline-block">
                                    <button class="btn bg-error text-white">Reject</button>
                                </form>
                            </div>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-xs mb-1 font-bold uppercase">Front Side</p>
                                <a href="../my-account/uploads/kyc/<?= $k['id_front'] ?>" target="_blank">
                                    <img src="../my-account/uploads/kyc/<?= $k['id_front'] ?>" class="rounded-lg border border-slate-200 dark:border-navy-500 h-40 w-full object-cover hover:opacity-75" alt="Front">
                                </a>
                            </div>
                            <div>
                                <p class="text-xs mb-1 font-bold uppercase">Back Side</p>
                                <a href="../my-account/uploads/kyc/<?= $k['id_back'] ?>" target="_blank">
                                    <img src="../my-account/uploads/kyc/<?= $k['id_back'] ?>" class="rounded-lg border border-slate-200 dark:border-navy-500 h-40 w-full object-cover hover:opacity-75" alt="Back">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
