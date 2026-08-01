<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(
        User $user,
        Order $order
    ): bool {
        return $this->isAdmin($user)
            || $this->ownsOrder($user, $order);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user)
            || $user->hasVerifiedEmail();
    }

    public function update(
        User $user,
        Order $order
    ): bool {
        /*
         * Admin dapat memperbarui status pesanan melalui Filament.
         */
        if ($this->isAdmin($user)) {
            return true;
        }

        /*
         * Pelanggan hanya boleh mengubah pesanan miliknya
         * selama belum dibayar dan belum dibatalkan.
         */
        return $this->ownsOrder($user, $order)
            && $order->payment_status !== 'paid'
            && $order->status !== 'cancelled';
    }

    public function delete(
        User $user,
        Order $order
    ): bool {
        /*
         * Admin tidak diberi izin hapus agar riwayat transaksi
         * tetap tersimpan. Pembatalan sebaiknya melalui status.
         */
        if ($this->isAdmin($user)) {
            return false;
        }

        return $this->ownsOrder($user, $order)
            && $order->payment_status !== 'paid'
            && in_array(
                $order->status,
                [
                    'pending_payment',
                    'pending',
                ],
                true
            );
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function pay(
        User $user,
        Order $order
    ): bool {
        return $this->ownsOrder($user, $order)
            && $order->payment_status !== 'paid'
            && $order->status === 'pending_payment'
            && ! $order->expires_at?->isPast();
    }

    public function restore(
        User $user,
        Order $order
    ): bool {
        return false;
    }

    public function restoreAny(User $user): bool
    {
        return false;
    }

    public function forceDelete(
        User $user,
        Order $order
    ): bool {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    private function isAdmin(User $user): bool
    {
        return $user->is_admin === true;
    }

    private function ownsOrder(
        User $user,
        Order $order
    ): bool {
        return (int) $order->user_id
            === (int) $user->id;
    }
}