<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ikris Pharma Network Dashboard – Login</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Config -->
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: '#2D62ED',
                    brandDark: '#1d4ed8'
                }
            }
        }
    }
    </script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

    <!-- MAIN WRAPPER -->
    <div class="w-full max-w-md bg-white shadow-xl rounded-xl p-8">

        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="<?= base_url(); ?>assets/images/iris_logo.svg" class="mx-auto h-14" alt="Ikris Logo">
            <h3 class="text-2xl font-bold mt-4">Named Patient Programs Dashboard</h3>
            <p class="text-gray-500 text-sm mt-1">Welcome back! Please login to continue.</p>
        </div>

        <!-- FLASH MESSAGE -->
        <?php if (!empty($this->session->flashdata("feedback"))) { ?>
        <div class="mb-4 p-3 text-sm text-red-600 bg-red-100 border border-red-300 rounded">
            <?= $this->session->flashdata("feedback"); ?>
        </div>
        <?php } ?>

        <!-- LOGIN FORM -->
        <form method="post" action="<?= base_url('login/Login_Auth'); ?>" class="space-y-4">

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="text" name="email" value="<?php if (isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>"
                    placeholder="Enter your email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand focus:outline-none">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password"
                    value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>"
                    placeholder="Enter your password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand focus:outline-none">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember-me"
                    class="h-4 w-4 text-brand focus:ring-brand border-gray-300 rounded">
                <label for="remember-me" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-brand hover:bg-brandDark text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Log In
            </button>

        </form>

        <!-- Footer Text -->
        <p class="mt-6 text-center text-gray-500 text-xs">
            © <?= date('Y'); ?> Ikris Pharma Network — All Rights Reserved
        </p>

    </div>

</body>

</html>
