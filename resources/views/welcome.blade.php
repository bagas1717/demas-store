<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Demas Store</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<div
    id="promoModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/75 p-4"
>
    <div
        id="promoCard"
        class="relative w-full max-w-3xl scale-90 opacity-0 transition duration-300"
    >
        <button
            id="closePromo"
            class="absolute -right-3 -top-3 z-20 grid h-10 w-10 place-items-center rounded-full bg-white text-xl font-bold text-black shadow-lg"
        >
            ×
        </button>

        <img
            src="{{ asset('images/promo-opening.jpg') }}"
            alt="Promo Demas Store"
            class="w-full rounded-2xl object-cover shadow-2xl"
        >
    </div>
</div>

<body class="bg-[#f4f2ed] text-[#171714]">

<header class="sticky top-0 z-50 border-b border-black/10 bg-[#f4f2ed]/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <a href="/" class="text-lg font-black tracking-tight">
            DEMAS<span class="text-emerald-800">STORE</span>
        </a>

        <nav class="hidden items-center gap-8 text-sm text-neutral-600 md:flex">
            <a href="#katalog" class="transition hover:text-black">Katalog</a>
            <a href="#tentang" class="transition hover:text-black">Tentang</a>
            <a href="#bantuan" class="transition hover:text-black">Bantuan</a>
        </nav>

        <button
            id="openCart"
            class="flex items-center gap-2 rounded-full border border-black/10 bg-white px-4 py-2 text-sm font-semibold shadow-sm transition hover:bg-neutral-50"
        >
            Keranjang

            <span
                id="cartCount"
                class="grid h-6 min-w-6 place-items-center rounded-full bg-emerald-900 px-1 text-xs font-bold text-white"
            >
                0
            </span>
        </button>

    </div>
</header>

<main>

    <section class="px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-5 lg:grid-cols-[1.35fr_0.65fr]">

            <div class="relative flex min-h-[420px] flex-col justify-between overflow-hidden rounded-3xl bg-emerald-950 p-7 text-white sm:p-10 lg:min-h-[520px]">

                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-white/60">
                        Pilihan barang sehari-hari
                    </p>

                    <h1 class="mt-5 max-w-4xl text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl lg:text-8xl">
                        Sedikit produk. Dipilih dengan baik.
                    </h1>

                    <p class="mt-6 max-w-xl text-sm leading-7 text-white/65 sm:text-base">
                        Katalog sederhana dengan informasi stok yang jelas,
                        checkout mandiri, dan pengalaman belanja yang nyaman
                        di semua ukuran layar.
                    </p>
                </div>

                <div class="relative z-10 mt-12 flex flex-wrap gap-7">
                    <div>
                        <strong class="block text-xl">24 jam</strong>
                        <span class="text-sm text-white/55">Katalog dapat diakses</span>
                    </div>

                    <div>
                        <strong class="block text-xl">QRIS</strong>
                        <span class="text-sm text-white/55">Pembayaran praktis</span>
                    </div>

                    <div>
                        <strong class="block text-xl">Real-time</strong>
                        <span class="text-sm text-white/55">Pembaruan stok</span>
                    </div>
                </div>

                <div class="absolute -bottom-32 -right-20 h-80 w-80 rounded-full border-[52px] border-white/5"></div>
            </div>

            <aside class="flex min-h-[250px] flex-col justify-end rounded-3xl bg-[#d8c5a8] p-7 sm:p-10 lg:min-h-full">

                <span class="w-fit rounded-full bg-white/60 px-3 py-1.5 text-xs font-bold">
                    Koleksi pilihan
                </span>

                <h2 class="mt-6 text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                    Barang yang berguna, tanpa tampilan yang berisik.
                </h2>

                <p class="mt-4 leading-7 text-[#655947]">
                    Desain berfokus pada produk, keterbacaan, dan alur transaksi yang singkat.
                </p>

            </aside>

        </div>
    </section>

    <section id="katalog" class="px-4 pb-24 pt-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="mb-7 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div>
                    <h2 class="text-3xl font-black tracking-tight sm:text-4xl">
                        Katalog
                    </h2>

                    <p id="resultText" class="mt-2 text-sm text-neutral-500">
                        Menampilkan seluruh produk
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <input
                        id="searchInput"
                        type="search"
                        placeholder="Cari produk..."
                        class="rounded-xl border border-black/10 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-900"
                    >

                    <select
                        id="sortSelect"
                        class="rounded-xl border border-black/10 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-900"
                    >
                        <option value="default">Urutkan</option>
                        <option value="low">Harga terendah</option>
                        <option value="high">Harga tertinggi</option>
                        <option value="stock">Stok terbanyak</option>
                    </select>
                </div>

            </div>

            <div
                id="productGrid"
                class="grid grid-cols-1 gap-4 min-[420px]:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            ></div>

        </div>
    </section>

</main>

<div
    id="cartBackdrop"
    class="pointer-events-none fixed inset-0 z-[60] bg-black/40 opacity-0 transition"
></div>

<aside
    id="cartDrawer"
    class="fixed right-0 top-0 z-[70] flex h-dvh w-full max-w-md translate-x-full flex-col bg-white transition duration-300"
>
    <div class="flex items-center justify-between border-b border-black/10 p-5">
        <h2 class="text-xl font-black">Keranjang</h2>

        <button
            id="closeCart"
            class="grid h-10 w-10 place-items-center rounded-full text-2xl transition hover:bg-neutral-100"
        >
            ×
        </button>
    </div>

    <div id="cartItems" class="flex-1 overflow-y-auto p-5"></div>

    <div class="border-t border-black/10 p-5">
        <div class="mb-4 flex items-center justify-between">
            <span class="text-neutral-500">Total</span>
            <strong id="cartTotal" class="text-lg">Rp0</strong>
        </div>

        <button
            id="checkoutButton"
            class="w-full rounded-xl bg-emerald-950 px-4 py-4 font-bold text-white transition hover:bg-emerald-900 disabled:cursor-not-allowed disabled:bg-neutral-300"
        >
            Lanjut ke pembayaran
        </button>
    </div>
</aside>

<footer
    id="tentang"
    class="border-t border-black/10 px-4 py-8 text-sm text-neutral-500 sm:px-6 lg:px-8"
>
    <div class="mx-auto max-w-7xl">
        © {{ date('Y') }} Demas Store
    </div>
</footer>

<script>
    const products = [
        {
            id: 1,
            name: 'Lampu Meja Awan',
            category: 'Rumah',
            price: 129000,
            stock: 8,
            color: '#476a58',
        },
        {
            id: 2,
            name: 'Botol Minum Tumbler',
            category: 'Aktivitas',
            price: 89000,
            stock: 14,
            color: '#b77a52',
        },
        {
            id: 3,
            name: 'Organizer Meja',
            category: 'Ruang Kerja',
            price: 74000,
            stock: 3,
            color: '#5f6579',
        },
        {
            id: 4,
            name: 'Tas Kanvas Harian',
            category: 'Aksesori',
            price: 149000,
            stock: 0,
            color: '#8f6d52',
        },
        {
            id: 5,
            name: 'Tempat Lilin Batu',
            category: 'Rumah',
            price: 59000,
            stock: 6,
            color: '#71746b',
        },
        {
            id: 6,
            name: 'Notebook Linen',
            category: 'Ruang Kerja',
            price: 45000,
            stock: 21,
            color: '#9a745d',
        },
        {
            id: 7,
            name: 'Jam Dinding Senyap',
            category: 'Rumah',
            price: 179000,
            stock: 2,
            color: '#3d505b',
        },
        {
            id: 8,
            name: 'Pouch Serbaguna',
            category: 'Aksesori',
            price: 67000,
            stock: 11,
            color: '#7d5556',
        },
    ];

    let cart = {};

    const productGrid = document.getElementById('productGrid');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const resultText = document.getElementById('resultText');

    const cartDrawer = document.getElementById('cartDrawer');
    const cartBackdrop = document.getElementById('cartBackdrop');
    const cartItems = document.getElementById('cartItems');
    const cartCount = document.getElementById('cartCount');
    const cartTotal = document.getElementById('cartTotal');
    const checkoutButton = document.getElementById('checkoutButton');

    const rupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(number);
    };

    const stockText = (stock) => {
        if (stock === 0) {
            return 'Habis';
        }

        if (stock <= 3) {
            return `Tersisa ${stock}`;
        }

        return `Stok ${stock}`;
    };

    function renderProducts() {
        const keyword = searchInput.value.toLowerCase().trim();
        const sort = sortSelect.value;

        let filteredProducts = products.filter((product) => {
            return (
                product.name.toLowerCase().includes(keyword) ||
                product.category.toLowerCase().includes(keyword)
            );
        });

        if (sort === 'low') {
            filteredProducts.sort((a, b) => a.price - b.price);
        }

        if (sort === 'high') {
            filteredProducts.sort((a, b) => b.price - a.price);
        }

        if (sort === 'stock') {
            filteredProducts.sort((a, b) => b.stock - a.stock);
        }

        resultText.textContent = `${filteredProducts.length} produk ditemukan`;

        productGrid.innerHTML = filteredProducts.map((product) => {
            return `
                <article class="overflow-hidden rounded-2xl border border-black/10 bg-white transition duration-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-black/5">

                    <div class="relative grid aspect-square place-items-center bg-neutral-200 p-6">

                        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1.5 text-xs font-bold">
                            ${stockText(product.stock)}
                        </span>

                        <div
                            class="h-[62%] w-[62%] rotate-[-8deg] rounded-[30%_48%_35%_52%] shadow-2xl"
                            style="background:${product.color}"
                        ></div>

                    </div>

                    <div class="p-4">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-neutral-400">
                            ${product.category}
                        </p>

                        <h3 class="mt-2 min-h-12 font-bold">
                            ${product.name}
                        </h3>

                        <div class="mt-4 flex items-center justify-between gap-3">
                            <strong>${rupiah(product.price)}</strong>

                            <button
                                onclick="addToCart(${product.id})"
                                class="grid h-10 w-10 place-items-center rounded-full bg-emerald-950 text-xl text-white transition hover:bg-emerald-900 disabled:cursor-not-allowed disabled:bg-neutral-300"
                                ${product.stock === 0 ? 'disabled' : ''}
                            >
                                +
                            </button>
                        </div>
                    </div>

                </article>
            `;
        }).join('');
    }

    function openCart() {
        cartDrawer.classList.remove('translate-x-full');

        cartBackdrop.classList.remove(
            'pointer-events-none',
            'opacity-0'
        );
    }

    function closeCart() {
        cartDrawer.classList.add('translate-x-full');

        cartBackdrop.classList.add(
            'pointer-events-none',
            'opacity-0'
        );
    }

    function addToCart(productId) {
        const product = products.find((item) => item.id === productId);
        const currentQuantity = cart[productId] ?? 0;

        if (currentQuantity < product.stock) {
            cart[productId] = currentQuantity + 1;
        }

        renderCart();
        openCart();
    }

    function changeQuantity(productId, amount) {
        const product = products.find((item) => item.id === productId);
        const newQuantity = (cart[productId] ?? 0) + amount;

        if (newQuantity <= 0) {
            delete cart[productId];
        } else if (newQuantity <= product.stock) {
            cart[productId] = newQuantity;
        }

        renderCart();
    }

    function removeCartItem(productId) {
        delete cart[productId];
        renderCart();
    }

    function renderCart() {
        const cartEntries = Object.entries(cart);

        const totalItems = cartEntries.reduce((total, [, quantity]) => {
            return total + quantity;
        }, 0);

        const totalPrice = cartEntries.reduce((total, [productId, quantity]) => {
            const product = products.find(
                (item) => item.id === Number(productId)
            );

            return total + product.price * quantity;
        }, 0);

        cartCount.textContent = totalItems;
        cartTotal.textContent = rupiah(totalPrice);
        checkoutButton.disabled = totalItems === 0;

        if (cartEntries.length === 0) {
            cartItems.innerHTML = `
                <div class="grid h-full place-items-center text-center text-neutral-400">
                    <div>
                        <p class="text-lg font-semibold">Keranjang kosong</p>
                        <p class="mt-1 text-sm">Tambahkan produk dari katalog.</p>
                    </div>
                </div>
            `;

            return;
        }

        cartItems.innerHTML = cartEntries.map(([productId, quantity]) => {
            const product = products.find(
                (item) => item.id === Number(productId)
            );

            return `
                <div class="grid grid-cols-[56px_1fr_auto] gap-3 border-b border-black/10 py-4">

                    <div
                        class="rounded-xl"
                        style="background:${product.color}25"
                    ></div>

                    <div>
                        <h4 class="text-sm font-bold">${product.name}</h4>
                        <p class="mt-1 text-sm text-neutral-500">
                            ${rupiah(product.price)}
                        </p>

                        <div class="mt-3 flex items-center gap-2">
                            <button
                                onclick="changeQuantity(${product.id}, -1)"
                                class="grid h-8 w-8 place-items-center rounded-lg border border-black/10"
                            >
                                −
                            </button>

                            <span class="min-w-6 text-center text-sm font-bold">
                                ${quantity}
                            </span>

                            <button
                                onclick="changeQuantity(${product.id}, 1)"
                                class="grid h-8 w-8 place-items-center rounded-lg border border-black/10"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <button
                        onclick="removeCartItem(${product.id})"
                        class="self-start text-xs font-bold text-red-700"
                    >
                        Hapus
                    </button>

                </div>
            `;
        }).join('');
    }

    document
        .getElementById('openCart')
        .addEventListener('click', openCart);

    document
        .getElementById('closeCart')
        .addEventListener('click', closeCart);

    cartBackdrop.addEventListener('click', closeCart);

    searchInput.addEventListener('input', renderProducts);
    sortSelect.addEventListener('change', renderProducts);

    checkoutButton.addEventListener('click', () => {
        alert('Tahap checkout dan QRIS akan dibuat setelah katalog selesai.');
    });

    renderProducts();
    renderCart();

    const promoModal = document.getElementById('promoModal');
    const promoCard = document.getElementById('promoCard');
    const closePromo = document.getElementById('closePromo');

    function showPromo() {
        promoModal.classList.remove('hidden');
        promoModal.classList.add('flex');

        setTimeout(() => {
            promoCard.classList.remove('scale-90', 'opacity-0');
            promoCard.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function hidePromo() {
        promoCard.classList.remove('scale-100', 'opacity-100');
        promoCard.classList.add('scale-90', 'opacity-0');

        setTimeout(() => {
            promoModal.classList.add('hidden');
            promoModal.classList.remove('flex');
        }, 300);

        sessionStorage.setItem('promoClosed', 'true');
    }

    window.addEventListener('load', () => {
        if (!sessionStorage.getItem('promoClosed')) {
            setTimeout(showPromo, 500);
        }
    });

    closePromo.addEventListener('click', hidePromo);

    promoModal.addEventListener('click', (event) => {
        if (event.target === promoModal) {
            hidePromo();
        }
    });

</script>

</body>
</html>