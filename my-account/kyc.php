<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Check existing KYC status
$stmt = $pdo->prepare("SELECT * FROM kyc WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$kyc = $stmt->fetch();

$status = $kyc['status'] ?? 'not_submitted';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $status !== 'approved') {
    $idType = $_POST['idType'] ?? '';
    $idNumber = $_POST['id_number'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $address = $_POST['address_line'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $postalCode = $_POST['postal_code'] ?? '';
    $country = $_POST['country'] ?? '';
    $phone = $_POST['phone'] ?? '';
    
    // File Upload Handling
    $uploadDir = __DIR__ . '/uploads/kyc/';
    $frontFile = $_FILES['id_front'] ?? null;
    $backFile = $_FILES['id_back'] ?? null;
    
    $frontPath = '';
    $backPath = '';
    
    if ($frontFile && $frontFile['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($frontFile['name'], PATHINFO_EXTENSION);
        $frontPath = 'kyc_' . $_SESSION['user_id'] . '_front_' . time() . '.' . $ext;
        move_uploaded_file($frontFile['tmp_name'], $uploadDir . $frontPath);
    }
    
    if ($backFile && $backFile['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($backFile['name'], PATHINFO_EXTENSION);
        $backPath = 'kyc_' . $_SESSION['user_id'] . '_back_' . time() . '.' . $ext;
        move_uploaded_file($backFile['tmp_name'], $uploadDir . $backPath);
    }
    
    try {
        $insertStmt = $pdo->prepare("INSERT INTO kyc (user_id, id_type, id_number, dob, address_line, city, state, postal_code, country, phone, id_front, id_back, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $insertStmt->execute([$_SESSION['user_id'], $idType, $idNumber, $dob, $address, $city, $state, $postalCode, $country, $phone, $frontPath, $backPath]);
        $message = "KYC documents submitted successfully! Our team will review them shortly.";
        $status = 'pending';
    } catch (PDOException $e) {
        $error = "Submission failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'partials/head.php'; ?>
    <title>KYC Verification - Tenvault</title>
</head>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="max-w-4xl mx-auto">
                <?php if ($message): ?>
                    <div class="mb-4 p-4 bg-success/10 text-success rounded-lg"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="mb-4 p-4 bg-error/10 text-error rounded-lg"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card p-6">
                    <h2 class="text-2xl font-bold mb-2">Identity Verification (KYC)</h2>
                    <p class="text-slate-500 mb-6">Required for account security and compliance.</p>

                    <?php if ($status === 'approved'): ?>
                        <div class="p-8 text-center">
                            <i class="fa fa-badge-check text-success text-6xl mb-4"></i>
                            <h3 class="text-xl font-bold">Your Account is Verified</h3>
                            <p>You have full access to all platform features.</p>
                        </div>
                    <?php elseif ($status === 'pending'): ?>
                        <div class="p-8 text-center">
                            <i class="fa fa-clock-rotate-left text-warning text-6xl mb-4"></i>
                            <h3 class="text-xl font-bold">Verification Pending</h3>
                            <p>We are currently reviewing your documents. Please check back later.</p>
                        </div>
                    <?php else: ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="block">
                                    <span>ID Type</span>
                                    <select name="idType" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required>
                                        <option value="Drivers License">Driver's License</option>
                                        <option value="International Passport">International Passport</option>
                                        <option value="National ID">National ID Card</option>
                                    </select>
                                </label>
                                <label class="block">
                                    <span>ID Number</span>
                                    <input name="id_number" type="text" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                </label>
                                <label class="block md:col-span-2">
                                    <span>Residential Address</span>
                                    <input name="address_line" type="text" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">
                                    <label class="block">
                                        <span>City</span>
                                        <input name="city" type="text" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                    </label>
                                    <label class="block">
                                        <span>Country</span>
                                        <input name="country" type="text" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                    </label>
                                </div>
                                <div class="md:col-span-2 mt-4">
                                    <p class="font-bold mb-2">Identity Documents</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <label class="block p-4 border-2 border-dashed border-slate-300 rounded-lg text-center cursor-pointer hover:border-primary">
                                            <span>Front of ID Card</span>
                                            <input name="id_front" type="file" class="hidden" required />
                                        </label>
                                        <label class="block p-4 border-2 border-dashed border-slate-300 rounded-lg text-center cursor-pointer hover:border-primary">
                                            <span>Back of ID Card</span>
                                            <input name="id_back" type="file" class="hidden" required />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn mt-6 bg-primary text-white px-8 py-3 rounded-lg w-full">Submit for Verification</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
