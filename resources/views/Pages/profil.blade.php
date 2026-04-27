@extends('layouts.app')

@section('title', 'My Profile - Stayzy Hotel')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap');

  .profile-wrap {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    background: #e8e0d4;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 100px 24px 60px;
  }

  .profile-shell {
    width: 100%;
    max-width: 1000px;
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* IDENTITY BAR */
  .identity-bar {
    background: #1a1a2e;
    border-radius: 20px;
    padding: 32px 48px;
    display: flex;
    align-items: center;
    gap: 24px;
    position: relative;
    overflow: hidden;
  }

  .identity-bar::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(184,169,138,0.15), transparent 70%);
    pointer-events: none;
  }

  .avatar-ring {
    width: 76px; height: 76px;
    border-radius: 50%;
    padding: 2.5px;
    background: linear-gradient(135deg, #c9a96e, #e8d5a3);
    flex-shrink: 0;
    position: relative; z-index: 1;
  }

  .avatar-ring img {
    width: 100%; height: 100%;
    border-radius: 50%;
    border: 3px solid #1a1a2e;
    display: block;
  }

  .identity-text {
    flex: 1;
    position: relative; z-index: 1;
  }

  .identity-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 28px;
    font-weight: 600;
    color: #f5f0e8;
    line-height: 1.2;
  }

  .identity-email {
    font-size: 13px;
    color: #94a3b8;
    margin-top: 4px;
  }



  /* CARDS */
  .card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 48px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
  }

  .section-label {
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #b8a98a;
    font-weight: 500;
    margin-bottom: 4px;
  }

  .section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 28px;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }

  .form-3col {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 18px;
  }

  .form-group label {
    display: block;
    font-size: 11px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #9e8f7a;
    font-weight: 500;
    margin-bottom: 8px;
  }

  .form-group input {
    width: 100%;
    padding: 13px 18px;
    border: 1.5px solid #e5ddd0;
    border-radius: 12px;
    font-size: 15px;
    font-family: 'DM Sans', sans-serif;
    color: #1a1a2e;
    background: #faf8f5;
    outline: none;
    transition: all 0.2s;
    box-sizing: border-box;
  }

  .form-group input:focus {
    border-color: #b8a98a;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(184,169,138,0.12);
  }

  .btn-row {
    display: flex;
    gap: 12px;
    margin-top: 28px;
  }

  .btn-primary {
    background: #1a1a2e;
    color: #f5f0e8;
    border: none;
    padding: 13px 32px;
    border-radius: 12px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    letter-spacing: 0.02em;
  }

  .btn-primary:hover {
    background: #2d2d4e;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(26,26,46,0.18);
  }

  .btn-ghost {
    background: transparent;
    color: #9e8f7a;
    border: 1.5px solid #e5ddd0;
    padding: 13px 28px;
    border-radius: 12px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-ghost:hover {
    border-color: #b8a98a;
    color: #1a1a2e;
  }

  @media (max-width: 768px) {
    .identity-bar { padding: 24px; flex-direction: column; text-align: center; }
    .form-row, .form-3col { grid-template-columns: 1fr; }
    .card { padding: 28px 24px; }
  }
</style>

<div class="profile-wrap">
  <div class="profile-shell">

    <!-- IDENTITY BAR -->
    <div class="identity-bar">
      <div class="avatar-ring">
        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&size=200&background=c9a96e&color=ffffff&bold=true" alt="avatar">
      </div>
      <div class="identity-text">
        <div class="identity-name">{{ $user->name }}</div>
        <div class="identity-email">{{ $user->email }}</div>
      </div>
    </div>

    <!-- ACCOUNT INFO -->
    <div class="card">
      <div class="section-label">Profile</div>
      <div class="section-title">Account Information</div>

      <form action="/profile/update" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ $user->name }}" placeholder="Your full name">
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ $user->email }}" placeholder="your@email.com">
          </div>
        </div>

        <div class="btn-row">
          <button type="submit" class="btn-primary">Save Changes</button>
        </div>
      </form>
    </div>

    <!-- CHANGE PASSWORD -->
    <div class="card">
      <div class="section-label">Security</div>
      <div class="section-title">Change Password</div>

      <form action="/profile/password" method="POST">
        @csrf
        @method('PUT')

        <div class="form-3col">
          <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" placeholder="Current password">
          </div>
          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" placeholder="New password">
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="new_password_confirmation" placeholder="Repeat new password">
          </div>
        </div>

        <div class="btn-row">
          <button type="submit" class="btn-primary">Update Password</button>
          <button type="reset" class="btn-ghost">Cancel</button>
        </div>
      </form>
    </div>

  </div>
</div>

@endsection