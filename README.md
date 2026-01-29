# IP Information Checker

A modern, fast, and privacy-focused tool to check your public IP address and network information. Built with the latest Laravel ecosystem stack.

![IP Checker Preview](https://placehold.co/800x400?text=IP+Checker+Preview)

## 🚀 Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend**: [Livewire 4](https://livewire.laravel.com)
- **Styling**: [Tailwind CSS 4](https://tailwindcss.com)
- **API**: [ipwho.is](https://ipwho.is) (for geolocation data)

## ✨ Features

- **Dual-Stack Detection**: 
  - **Server-side**: Detects the IP used to connect to the application.
  - **Client-side**: Probes for both IPv4 and IPv6 connectivity specifically to ensure you see your full network profile.
- **Detailed Location Data**: Displays City, Region, Country (with flag), and Continent.
- **Network Insights**: Shows ISP, ASN, and Timezone information.
- **Modern UI**: Clean, responsive card layout with automatic Dark Mode support.
- **Developer Friendly**: One-click copy for all IP addresses.

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd myip
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   pnpm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Start the Development Server**
   ```bash
   # Terminal 1: Start Laravel server
   php artisan serve

   # Terminal 2: Start Vite (for Tailwind 4)
   npm run dev
   ```

6. **Visit the App**
   Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

## 📝 Usage Notes

- **Local Development**: If you are running locally (e.g., `localhost` or `127.0.0.1`), the app will simulate an external IP (defaults to `8.8.8.8`) for the server-side check so you can see the UI populated with data. The client-side checks will still show your actual local network exit IPs.
