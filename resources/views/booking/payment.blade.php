@extends('layouts.app')

@section('title', 'Payment - Stayzy Hotel')

@section('content')


<div class="min-h-screen bg-gray-200 flex items-center justify-center px-4 py-10 mt-20">
  <div class="bg-white rounded-2xl shadow-lg w-full max-w-md overflow-hidden">

    {{-- Step indicator --}}
    <div class="bg-gray-50 border-b border-gray-200 px-6 py-3 flex items-center gap-2 text-sm">
      <span class="text-gray-400">1. Fill in data</span>
      <div class="flex-1 border-t border-dashed border-gray-300"></div>
      <span class="font-semibold text-gray-700">2. Payment</span>
    </div>

    {{-- Body --}}
    <div class="p-6 space-y-5">

      {{-- Payment method --}}
      <div>
        <p class="text-sm font-semibold text-gray-700 mb-2">Payment</p>
        <div class="border border-gray-200 rounded-xl p-4 flex items-center justify-between">
          <div>
            <p class="font-semibold text-gray-800">Bank Transfer BCA</p>
            <p class="text-sm text-gray-500 mt-0.5">
              Nomor Rekening : <span class="font-bold text-gray-800">9912783747</span>
            </p>
          </div>
          <div class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg tracking-wide">BCA</div>
        </div>
      </div>

      {{-- Upload --}}
      <div>
        <p class="text-sm font-semibold text-gray-700 mb-2">Upload Invoice Transfer</p>
        <label class="inline-flex items-center gap-2 px-5 py-2 border border-gray-300 rounded-full cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition text-sm text-gray-500">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
          </svg>
          Choose file
          <input type="file" class="hidden" />
        </label>
      </div>

      {{-- Buttons --}}
      <form method="POST" action="{{ route('payment.order') }}">
        @csrf
        <button type="submit"
          class="w-full py-3 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-bold text-sm transition">
          Order
        </button>
      </form>

      <form method="POST" action="{{ route('payment.cancel') }}">
        @csrf
        <button type="submit"
          class="w-full py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold text-sm transition">
          Cancel
        </button>
      </form>

      {{-- Note --}}
      <p class="text-xs text-gray-400 leading-relaxed">
        We would like to inform you that your invoice will be sent shortly via email
        by our admin team. Please check your inbox (and spam folder, if necessary)
        to ensure you receive it.
      </p>

    </div>
  </div>
</div>

@endsection