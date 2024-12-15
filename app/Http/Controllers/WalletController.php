<?php

namespace App\Http\Controllers;
use App\Models\Wallet;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function showDepositForm()
    {
        return view('back.page.client.wallet.deposit');
    }

    // public function deposit(Request $request)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric|min:1',
    //     ]);

    //     $client = auth('client')->user();

    //     $wallet = Wallet::firstOrCreate(
    //         ['user_id' => $client->id, 'user_type' => 'client'],
    //         ['balance' => 0]
    //     );

    //     $amount = $request->input('amount');
    //     $wallet->balance += $amount;
    //     $wallet->save();

    //     $mailData = [
    //         'type' => 'Deposit',
    //         'amount' => $amount,
    //         'balance' => $wallet->balance,
    //         'user_name' => $client->name,
    //     ];

    //     Mail::send('email-templates.wallet-transaction', $mailData, function ($message) use ($client) {
    //         $message->to($client->email, $client->name)
    //                 ->subject('Wallet Deposit Notification')
    //                 ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    //     });

    //     return redirect()->route('wallet.deposit.form')->with('success', 'Deposit successful!');
    // }


    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $client = auth('client')->user();

        // Tìm hoặc tạo ví cho Client
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $client->id, 'user_type' => 'client'],
            ['balance' => 0]
        );

        $amount = $request->input('amount');
        $wallet->balance += $amount; // Thêm số tiền vào ví
        $wallet->save();

        // Dữ liệu gửi mail
        $mailData = [
            'type' => 'Deposit',
            'amount' => $amount,
            'balance' => $wallet->balance,
            'user_name' => $client->name,
        ];

        // Render nội dung email
        $mailBody = view('email-templates.wallet-transaction', $mailData)->render();

        // Cấu hình gửi mail
        $mailConfig = [
            'mail_from_email' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $client->email,
            'mail_recipient_name' => $client->name,
            'mail_subject' => 'Wallet Deposit Notification',
            'mail_body' => $mailBody,
        ];

        // Gửi email
        sendEmail($mailConfig);

        return redirect()->route('wallet.deposit.form')->with('success', 'Deposit successful!');
    }

    public function showBalance()
    {
        $client = auth('client')->user();

        $wallet = Wallet::where('user_id', $client->id)
                        ->where('user_type', 'client')
                        ->first();

        if (!$wallet) {
            $wallet = Wallet::create([
                'user_id' => $client->id,
                'user_type' => 'client',
                'balance' => 0,
            ]);
        }

        return view('back.page.client.wallet.balance', ['wallet' => $wallet]);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $client = auth('client')->user();

        $wallet = Wallet::where('user_id', $client->id)
                        ->where('user_type', 'client')
                        ->first();

        if (!$wallet) {
            return redirect()->back()->with('error', 'Wallet not found.');
        }

        $amount = $request->input('amount');

        if ($amount > $wallet->balance) {
            return redirect()->back()->with('error', 'Insufficient wallet balance.');
        }

        $wallet->balance -= $amount;
        $wallet->save();

        $mailData = [
            'type' => 'Withdraw',
            'amount' => $amount,
            'balance' => $wallet->balance,
            'user_name' => $client->name,
        ];

        $mailBody = view('email-templates.wallet-transaction', $mailData)->render();
        $mailConfig = [
            'mail_from_email' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $client->email,
            'mail_recipient_name' => $client->name,
            'mail_subject' => 'Wallet Withdraw Notification',
            'mail_body' => $mailBody,
        ];

        sendEmail($mailConfig);

        return redirect()->route('wallet.balance')->with('success', 'Withdraw successful!');
    }

    public function showSellerWallet()
{
    $seller = auth('seller')->user();

    $wallet = Wallet::where('user_id', $seller->id)
                    ->where('user_type', 'seller')
                    ->first();

    if (!$wallet) {
        $wallet = Wallet::create([
            'user_id' => $seller->id,
            'user_type' => 'seller',
            'balance' => 0,
        ]);
    }

    return view('back.page.seller.wallet.view', ['wallet' => $wallet]);
}

public function withdrawSeller(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $seller = auth('seller')->user();

    $wallet = Wallet::where('user_id', $seller->id)->where('user_type', 'seller')->first();

    if (!$wallet || $wallet->balance < $request->amount) {
        return redirect()->route('seller.wallet.view')->with('error', 'Insufficient balance!');
    }

    $withdrawAmount = $request->amount;
    $adminFee = $withdrawAmount * 0.05;
    $finalAmount = $withdrawAmount - $adminFee;

    $wallet->balance -= $withdrawAmount;
    $wallet->save();

    $adminWallet = Wallet::where('user_id', 1)->where('user_type', 'admin')->first(); // Assuming admin ID is 1
    if ($adminWallet) {
        $adminWallet->balance += $adminFee;
        $adminWallet->save();
    }
    $mailData = [
        'name' => $seller->name,
        'email' => $seller->email,
        'withdrawAmount' => $withdrawAmount,
        'finalAmount' => $finalAmount,
        'adminFee' => $adminFee,
        'remainingBalance' => $wallet->balance,
    ];

    $mailBody = view('email-templates.seller-withdraw-notification', $mailData)->render();

    $mailConfig = [
        'mail_from_email' => env('MAIL_FROM_ADDRESS'),
        'mail_from_name' => env('MAIL_FROM_NAME'),
        'mail_recipient_email' => $seller->email,
        'mail_recipient_name' => $seller->name,
        'mail_subject' => 'Withdraw Confirmation',
        'mail_body' => $mailBody,
    ];

    sendEmail($mailConfig);

    return redirect()->route('seller.wallet.view')->with('success', 'Withdrawal successful! Check your email for details.');
}

public function showAdminWallet()
{
    $admin = auth('admin')->user();

    $wallet = Wallet::where('user_id', $admin->id)->where('user_type', 'admin')->first();

    if (!$wallet) {
        $wallet = Wallet::create([
            'user_id' => $admin->id,
            'user_type' => 'admin',
            'balance' => 0,
        ]);
    }

    return view('back.page.admin.wallet.view', ['wallet' => $wallet]);
}

public function withdrawAdmin(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $admin = auth('admin')->user();

    $wallet = Wallet::where('user_id', $admin->id)->where('user_type', 'admin')->first();

    if (!$wallet || $wallet->balance < $request->amount) {
        return redirect()->route('admin.wallet.view')->with('error', 'Insufficient balance!');
    }

    $withdrawAmount = $request->amount;
    $wallet->balance -= $withdrawAmount;
    $wallet->save();

    $mailData = [
        'name' => $admin->name,
        'email' => $admin->email,
        'withdrawAmount' => $withdrawAmount,
        'remainingBalance' => $wallet->balance,
    ];

    $mailBody = view('email-templates.admin-withdraw-notification', $mailData)->render();

    $mailConfig = [
        'mail_from_email' => env('MAIL_FROM_ADDRESS'),
        'mail_from_name' => env('MAIL_FROM_NAME'),
        'mail_recipient_email' => $admin->email,
        'mail_recipient_name' => $admin->name,
        'mail_subject' => 'Withdraw Confirmation',
        'mail_body' => $mailBody,
    ];

    sendEmail($mailConfig);

    return redirect()->route('admin.wallet.view')->with('success', 'Withdrawal successful! Check your email for details.');
}

}
