<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;

// class MailController extends Controller
// {
//     public function sendMail(Request $request)
//     {
//         $validated = $request->validate([
//             'email' => 'required|email',
//             'subject' => 'required|string',
//             'total' => 'required|string',
//             'name' => 'required|string',
//             'order' => 'required|array',
//         ]);

//         $data = [
//             'subject' => $validated['subject'],
//             'total' => $validated['total'],
//             'name' => $validated['name'],
//             'order' => $validated['order'],
//         ];

//         Mail::send('emails.notification', $data, function ($message) use ($validated) {
//             $message->to($validated['email'])
//                 ->subject($validated['subject']);
//         });

//         return response()->json(['message' => 'Email đã được gửi thành công!']);
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'subject' => 'required|string',
            'total' => 'required|string',
            'name' => 'required|string',
            'order' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Dữ liệu sau khi đã xác thực
        $validated = $validator->validated();

        $data = [
            'subject' => $validated['subject'],
            'total' => $validated['total'],
            'name' => $validated['name'],
            'order' => $validated['order'],
        ];

        // Gửi email
        try {
            Mail::send('emails.notification', $data, function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject($validated['subject']);
            });

            return response()->json(['message' => 'Email đã được gửi thành công!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gửi email không thành công.', 'error' => $e->getMessage()], 500);
        }
    }
}
