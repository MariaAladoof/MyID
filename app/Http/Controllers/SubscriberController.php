<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


use App\Http\Requests\StoreSubscriberRequest;


class SubscriberController extends Controller
{

    // الخاصة بالمستخدم المصادق عليه Subscribers عرض
    public function index(Request  $request): JsonResponse
    {
        $subscribers = $request->user()
            ->subscribers()
            ->latest()
            ->paginate(15);

        return response()->json([
            'message' => 'تم جلب البيانات بنجاح',
            'data' => $subscribers,
        ]);
    }

    //Subscriber جديد إضافة
    public function store(StoreSubscriberRequest $request): JsonResponse
    {
        $subscriber = $request->user()->subscribers()->create($request->validated());
        return response()->json([
            'message' => 'تم إضافة Subscriber بنجاح',
            'data' => $subscriber,
        ], 201);
    }
}
