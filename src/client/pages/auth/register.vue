<template>
  <div
    class="
      container
      mx-auto
      pt-24
      pb-12
      px-6
      min-h-screen
      bg-black
      flex flex-col
      items-center
      justify-center
    "
  >
    <div class="max-w-xl flex flex-col w-full">
      <div class="flex items-center">
        <div v-if="mustVerifyEmail" :title="$t('register')">
          <div class="alert alert-success" role="alert">
            {{ $t('verify_email_address') }}
          </div>
        </div>
        <div v-else class="w-full">
          <form
            class="w-full"
            @submit.prevent="register"
            @keydown="form.onKeydown($event)"
          >
            <div class="w-80 max-w-xs m-auto">
              <img src="~/assets/svg/logo-strap.svg" alt="Red6Six logo" />
              <h1 class="text-white text-2xl text-center mt-8 mb-8">
                Register
              </h1>
            </div>
            <div class="grid lg:grid-cols-2 col-gap-6 align-baseline">
              <div class="group">
                <label
                  class="
                    text-white
                    group-focus:text-red-600
                    transition-colors
                    duration-300
                  "
                >
                  {{ $t('firstName') }} *
                </label>
                <input
                  v-model="form.firstName"
                  :class="{ 'is-invalid': form.errors.has('firstName') }"
                  type="text"
                  name="firstName"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    border-b
                    bg-transparent
                    group-focus:border-red
                    focus:outline-none focus:border-red
                  "
                />
                <has-error :form="form" field="firstName" />
              </div>
              <div class="group">
                <label
                  class="
                    text-white
                    group-focus:text-red-600
                    transition-colors
                    duration-300
                  "
                >
                  {{ $t('lastName') }} *
                </label>
                <input
                  v-model="form.lastName"
                  :class="{ 'is-invalid': form.errors.has('lastName') }"
                  type="text"
                  name="lastName"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    border-b
                    bg-transparent
                    group-focus:border-red
                    focus:outline-none focus:border-red
                  "
                />
                <has-error :form="form" field="lastName" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('email') }} *
                </label>
                <input
                  v-model="form.email"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                  type="email"
                  name="email"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="email" />
              </div>
              <div class="group">
                <label class="text-white block mt-5"> {{ $t('dob') }} * </label>
                <input
                  v-model="form.dob"
                  :class="{
                    'is-invalid': form.errors.has('dob'),
                  }"
                  type="date"
                  name="dob"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="dob" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('username') }} *
                </label>
                <input
                  v-model="form.username"
                  :class="{
                    'is-invalid': form.errors.has('username'),
                  }"
                  type="text"
                  name="username"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="username" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('phone') }} *
                </label>
                <input
                  v-model="form.phone"
                  :class="{
                    'is-invalid': form.errors.has('phone'),
                  }"
                  type="text"
                  name="phone"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="phone" />
              </div>
              <div class="group" style="position:relative;">
                <label class="text-white block mt-5">
                  {{ $t('password') }} *
                </label>
                <input
                  v-model="form.password"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                  :type="passwordType"
                  name="password"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    border-b
                    bg-transparent
                    focus:outline-none focus:border-red
                  "
                />
                <span class="
                  inline-block
                  h-8
                  mt-4
                  w-8
                  text-white
                  hover:text-red
                  transition-colors
                  duration-300
                  cursor-pointer
                  text-center
                "
                @click="toggleShowPassword"
                style="
                  position:absolute;
                  right: -10px;
                "
                >
                  <svg
                    v-if="passwordVisible == true"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    viewBox="0 0 200 200"
                    enable-background="new 0 0 200 200"
                    xml:space="preserve"
                  >
                    <path
                      class="fill-current"
                      d="M64.444,30.001c24.374,0.19 49.922,9.735 62.228,30.594c0.585,0.992 1.323,2.479 1.323,2.479c0.739,1.976 -1.234,4.17 -2.723,6.404c-12.935,19.399 -37.627,28.522 -61.507,28.522c-24.269,0 -50.062,-9.445 -62.05,-30.589c-0.615,-1.085 -1.379,-2.721 -1.379,-2.721c-0.52,-1.494 0.721,-3.14 1.684,-4.753c11.808,-19.784 36.516,-29.743 61.276,-29.936c0.383,-0.001 0.765,-0.001 1.148,0Zm-1.127,4c-21.626,0.169 -43.742,7.796 -56.05,25.208c-1.057,1.495 -2.034,3.052 -2.869,4.682c0,0 3.081,5.632 6.767,9.721c13.377,14.834 34.636,20.785 54.803,20.365c22.83,-0.475 46.856,-9.45 57.836,-29.797c0,0 0.045,-0.454 -0.168,-0.839c-10.846,-19.342 -35.36,-29.154 -59.213,-29.34c-0.369,-0.001 -0.737,-0.001 -1.106,0Zm1.028,15c9.905,0.188 17.976,11.856 13.325,21.502c-4.061,8.424 -16.853,11.041 -23.866,4.353c-8.237,-7.855 -3.561,-25.595 10.154,-25.855c0.193,-0.001 0.193,-0.001 0.387,0Zm-0.336,4c-7.254,0.137 -13.177,8.704 -9.773,15.764c2.981,6.185 12.358,8.102 17.502,3.196c3.46,-3.298 4.392,-8.958 2.086,-13.2c-1.921,-3.536 -5.498,-5.788 -9.815,-5.76Z"
                    />
                  </svg>
                  <svg
                    v-else-if="passwordVisible == false"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    viewBox="0 0 200 200"
                    enable-background="new 0 0 200 200"
                    xml:space="preserve"
                  >
                    <path
                      class="fill-current"
                      d="M73.562,52.323l37.737,-37.737c0.413,-0.361 0.623,-0.673 1.754,-0.557c1.441,0.351 2.162,2.138 1.074,3.385l-37.793,37.793c3.084,4.086 4.332,9.591 2.199,14.631c-3.089,7.296 -12.586,11.11 -19.874,7.888c-1.086,-0.48 -2.092,-1.101 -3.008,-1.836l-37.524,37.524c-0.91,0.794 -1.353,0.704 -2.019,0.492c-1.291,-0.409 -1.774,-2.214 -0.809,-3.32l37.601,-37.601c-3.203,-4.425 -4.145,-10.583 -1.626,-15.651c2.519,-5.067 7.563,-8.372 13.634,-8.333c3.191,0.062 6.2,1.321 8.654,3.322Zm23.876,-15.376c1.054,0.208 1.1,0.376 1.571,0.573c12.276,5.169 24.115,13.554 29.537,25.529c0,0 0.295,1.184 -0.415,2.565c-11.251,21.891 -39.324,32.584 -64.921,32.382c-6.675,-0.053 -13.382,-0.554 -19.893,-1.983c0,0 -1.814,-0.365 -2.095,-1.658c-0.325,-1.493 0.781,-2.726 3.243,-2.186c28.156,6.04 60.74,-0.832 77.094,-23.545c1.084,-1.505 2.089,-3.072 2.951,-4.715l0.003,-0.008c-5.595,-10.713 -16.525,-18.406 -27.821,-23.01c0,0 -1.443,-0.625 -1.513,-1.848c-0.067,-1.177 0.994,-2.183 2.259,-2.096Zm-32.608,-6.946c7.359,0.039 14.716,0.785 21.882,2.527c0.743,0.181 1.747,0.837 1.824,1.87c0.106,1.442 -0.868,2.466 -3.36,1.876c-28.03,-6.527 -60.437,-0.614 -77.142,22.647c-1.133,1.577 -2.18,3.223 -3.064,4.952c5.815,10.606 15.977,18.335 27.016,23.228c0,0 1.872,1.468 0.834,2.967c-0.711,1.027 -2.163,0.831 -3.465,0.235c-11.78,-5.438 -22.699,-13.757 -28.401,-25.489c0,0 -0.33,-1.198 0.368,-2.592c10.696,-21.352 37.792,-32.269 63.508,-32.221Zm8.947,27.764l-15.163,15.162c1.762,1.287 3.871,2.072 6.099,2.073c7.485,0.002 13.672,-9.144 9.591,-16.387c-0.164,-0.292 -0.34,-0.575 -0.527,-0.848Zm-2.819,-2.839c-1.8,-1.242 -3.988,-1.941 -6.387,-1.925c-5.076,0.096 -9.786,4.018 -10.686,9.051c-0.502,2.808 0.308,5.686 1.934,8.014l15.139,-15.14Z"
                    />
                  </svg>
                </span>
                <has-error :form="form" field="password" />
              </div>
              <div class="group" style="position:relative;">
                <label class="text-white block mt-5">
                  {{ $t('confirm_password') }} *
                </label>
                <input
                  v-model="form.password_confirmation"
                  :class="{
                    'is-invalid': form.errors.has('password_confirmation'),
                  }"
                  :type="confirmPasswordType"
                  name="password_confirmation"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <span class="
                  inline-block
                  h-8
                  mt-4
                  w-8
                  text-white
                  hover:text-red
                  transition-colors
                  duration-300
                  cursor-pointer
                  text-center
                "
                @click="toggleShowConfirmPassword"
                style="
                  position:absolute;
                  right: -10px;
                "
                >
                  <svg
                    v-if="confirmPasswordVisible == true"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    viewBox="0 0 200 200"
                    enable-background="new 0 0 200 200"
                    xml:space="preserve"
                  >
                    <path
                      class="fill-current"
                      d="M64.444,30.001c24.374,0.19 49.922,9.735 62.228,30.594c0.585,0.992 1.323,2.479 1.323,2.479c0.739,1.976 -1.234,4.17 -2.723,6.404c-12.935,19.399 -37.627,28.522 -61.507,28.522c-24.269,0 -50.062,-9.445 -62.05,-30.589c-0.615,-1.085 -1.379,-2.721 -1.379,-2.721c-0.52,-1.494 0.721,-3.14 1.684,-4.753c11.808,-19.784 36.516,-29.743 61.276,-29.936c0.383,-0.001 0.765,-0.001 1.148,0Zm-1.127,4c-21.626,0.169 -43.742,7.796 -56.05,25.208c-1.057,1.495 -2.034,3.052 -2.869,4.682c0,0 3.081,5.632 6.767,9.721c13.377,14.834 34.636,20.785 54.803,20.365c22.83,-0.475 46.856,-9.45 57.836,-29.797c0,0 0.045,-0.454 -0.168,-0.839c-10.846,-19.342 -35.36,-29.154 -59.213,-29.34c-0.369,-0.001 -0.737,-0.001 -1.106,0Zm1.028,15c9.905,0.188 17.976,11.856 13.325,21.502c-4.061,8.424 -16.853,11.041 -23.866,4.353c-8.237,-7.855 -3.561,-25.595 10.154,-25.855c0.193,-0.001 0.193,-0.001 0.387,0Zm-0.336,4c-7.254,0.137 -13.177,8.704 -9.773,15.764c2.981,6.185 12.358,8.102 17.502,3.196c3.46,-3.298 4.392,-8.958 2.086,-13.2c-1.921,-3.536 -5.498,-5.788 -9.815,-5.76Z"
                    />
                  </svg>
                  <svg
                    v-else-if="confirmPasswordVisible == false"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    viewBox="0 0 200 200"
                    enable-background="new 0 0 200 200"
                    xml:space="preserve"
                  >
                    <path
                      class="fill-current"
                      d="M73.562,52.323l37.737,-37.737c0.413,-0.361 0.623,-0.673 1.754,-0.557c1.441,0.351 2.162,2.138 1.074,3.385l-37.793,37.793c3.084,4.086 4.332,9.591 2.199,14.631c-3.089,7.296 -12.586,11.11 -19.874,7.888c-1.086,-0.48 -2.092,-1.101 -3.008,-1.836l-37.524,37.524c-0.91,0.794 -1.353,0.704 -2.019,0.492c-1.291,-0.409 -1.774,-2.214 -0.809,-3.32l37.601,-37.601c-3.203,-4.425 -4.145,-10.583 -1.626,-15.651c2.519,-5.067 7.563,-8.372 13.634,-8.333c3.191,0.062 6.2,1.321 8.654,3.322Zm23.876,-15.376c1.054,0.208 1.1,0.376 1.571,0.573c12.276,5.169 24.115,13.554 29.537,25.529c0,0 0.295,1.184 -0.415,2.565c-11.251,21.891 -39.324,32.584 -64.921,32.382c-6.675,-0.053 -13.382,-0.554 -19.893,-1.983c0,0 -1.814,-0.365 -2.095,-1.658c-0.325,-1.493 0.781,-2.726 3.243,-2.186c28.156,6.04 60.74,-0.832 77.094,-23.545c1.084,-1.505 2.089,-3.072 2.951,-4.715l0.003,-0.008c-5.595,-10.713 -16.525,-18.406 -27.821,-23.01c0,0 -1.443,-0.625 -1.513,-1.848c-0.067,-1.177 0.994,-2.183 2.259,-2.096Zm-32.608,-6.946c7.359,0.039 14.716,0.785 21.882,2.527c0.743,0.181 1.747,0.837 1.824,1.87c0.106,1.442 -0.868,2.466 -3.36,1.876c-28.03,-6.527 -60.437,-0.614 -77.142,22.647c-1.133,1.577 -2.18,3.223 -3.064,4.952c5.815,10.606 15.977,18.335 27.016,23.228c0,0 1.872,1.468 0.834,2.967c-0.711,1.027 -2.163,0.831 -3.465,0.235c-11.78,-5.438 -22.699,-13.757 -28.401,-25.489c0,0 -0.33,-1.198 0.368,-2.592c10.696,-21.352 37.792,-32.269 63.508,-32.221Zm8.947,27.764l-15.163,15.162c1.762,1.287 3.871,2.072 6.099,2.073c7.485,0.002 13.672,-9.144 9.591,-16.387c-0.164,-0.292 -0.34,-0.575 -0.527,-0.848Zm-2.819,-2.839c-1.8,-1.242 -3.988,-1.941 -6.387,-1.925c-5.076,0.096 -9.786,4.018 -10.686,9.051c-0.502,2.808 0.308,5.686 1.934,8.014l15.139,-15.14Z"
                    />
                  </svg>
                </span>
                <has-error :form="form" field="password_confirmation" />
              </div>
              <div class="group" style="grid-column: 1/-1">
                <label class="text-white block mt-5">
                  {{ $t('address') }} *
                </label>
                <input
                  v-model="form.address"
                  :class="{
                    'is-invalid': form.errors.has('address'),
                  }"
                  type="text"
                  name="address"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="address" />
              </div>
              <div class="group" style="grid-column: 1/-1">
                <label class="text-white block mt-5">
                  {{ $t('address2') }}
                </label>
                <input
                  v-model="form.address2"
                  :class="{
                    'is-invalid': form.errors.has('address2'),
                  }"
                  type="text"
                  name="address2"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="address2" />
              </div>
              <div class="group" style="grid-column: 1/-1">
                <label class="text-white block mt-5">
                  {{ $t('address3') }}
                </label>
                <input
                  v-model="form.address3"
                  :class="{
                    'is-invalid': form.errors.has('address3'),
                  }"
                  type="text"
                  name="address3"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="address3" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('city') }} *
                </label>
                <input
                  v-model="form.city"
                  :class="{
                    'is-invalid': form.errors.has('city'),
                  }"
                  type="text"
                  name="city"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="city" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('county') }}
                </label>
                <input
                  v-model="form.county"
                  :class="{
                    'is-invalid': form.errors.has('county'),
                  }"
                  type="text"
                  name="county"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="postcode" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('postcode') }} *
                </label>
                <input
                  v-model="form.postcode"
                  :class="{
                    'is-invalid': form.errors.has('postcode'),
                  }"
                  type="text"
                  name="postcode"
                  class="
                    bg-brand
                    text-white
                    px-2
                    h-8
                    mt-4
                    mb-4
                    w-full
                    border-white
                    transition-colors
                    duration-300
                    focus:border-red
                    border-b
                    bg-transparent
                    focus:outline-none
                  "
                />
                <has-error :form="form" field="postcode" />
              </div>
              <div class="group">
                <label class="text-white block mt-5">
                  {{ $t('country') }} *
                </label>
                <select
                  v-model="form.country_id"
                  name="country"
                  class="w-full h-12 bg-white text-gray-900 border-r p-1"
                >
                  <option value="">Select Country</option>
                  <option
                    v-for="country in getConstants['countries']"
                    :key="country.id"
                    :value="country.id"
                  >
                    {{ country.name }}
                  </option>
                </select>
              </div>
              <div class="group" style="grid-column: 1/-1">
                <label class="text-white block mt-5">
                  {{ $t('howDidYouHearABoutUs') }}
                </label>
                <select
                  v-model="form.hear_about_us_platform_id"
                  name="howDidYouHearABoutUs"
                  class="w-full h-12 bg-white text-gray-900 border-r p-1"
                >
                  <option value="">Select Platform</option>
                  <option
                    v-for="platform in getConstants['hearAboutUsPlatforms']"
                    :key="platform.id"
                    :value="platform.id"
                  >
                    {{ platform.name }}
                  </option>
                </select>
              </div>
              <div class="group" style="grid-column: 1/-1">
                <checkbox
                  v-model="form.over18"
                  name="over18"
                  class="text-white block mt-5"
                  :value="form.over18"
                >
                  Confirm you are over 18
                </checkbox>
                <has-error :form="form" field="over18" />
              </div>
              <div class="group" style="grid-column: 1/-1">
                <checkbox
                  v-model="form.accept_terms"
                  name="remember"
                  class="text-white block mt-5"
                  :value="form.accept_terms"
                >
                  By ticking this box you accept our terms and conditions
                  <router-link
                    :to="{ name: 'terms-and-conditions' }"
                    class="
                      text-red
                      hover:text-gold
                      transition-colors
                      duration-300
                      inline-block
                    "
                  >
                    here
                  </router-link>
                </checkbox>
                <has-error :form="form" field="accepts_terms" />
              </div>
            </div>
            <button
              :class="[
                'btn mt-5 w-full bg-grey',
                { disabled: !form.accept_terms },
              ]"
              :disabled="!form.accept_terms"
            >
              {{ $t('register') }}
            </button>
          </form>
        </div>
      </div>
      <div class="mt-16 text-center">
        <p class="text-white inline-block">Already a user?</p>
        <router-link
          class="
            text-red
            hover:text-gold
            transition-colors
            duration-300
            inline-block
          "
          :to="{ name: 'login' }"
        >
          Sign in
        </router-link>
        <p class="text-white inline-block">here</p>
      </div>
    </div>
  </div>
</template>
<script>
import Form from 'vform'
import swal from 'sweetalert2'
import { mapGetters } from 'vuex'

export default {
  async asyncData({ store }) {
    await store.dispatch('ConstantStore/getConstants')
  },
  data: () => ({
    form: new Form({
      firstName: null,
      lastName: null,
      username: '',
      email: null,
      password: null,
      password_confirmation: null,
      phone: null,
      address: null,
      address2: null,
      address3: null,
      city: null,
      county: null,
      postcode: null,
      dob: null,
      country_id: '',
      hear_about_us_platform_id: '',
      accept_terms: false,
      over18: false,
    }),
    mustVerifyEmail: false,
    passwordVisible: false,
    confirmPasswordVisible: false,
    confirmPasswordType: 'password',
    passwordType: 'password',
  }),
  layout: 'default',
  computed: {
    ...mapGetters('ConstantStore', ['getConstants', 'errorMessage']),
  },
  methods: {
    async register() {
      // Register the user.
      if (
        !this.form.firstName ||
        !this.form.lastName ||
        !this.form.username ||
        !this.form.email ||
        !this.form.password ||
        !this.form.password_confirmation ||
        !this.form.phone ||
        !this.form.address ||
        !this.form.dob ||
        !this.form.country_id ||
        !this.form.city ||
        !this.form.postcode ||
        !this.form.accept_terms ||
        !this.form.over18
      ) {
        const text = this.$t('required_fields_error')

        swal.fire({
          text,
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      if (this.form.password !== this.form.password_confirmation) {
        swal.fire({
          text: 'Passwords does not match',
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      try {
        await this.$store
          .dispatch('auth/register', {
            first_name: this.form.firstName,
            last_name: this.form.lastName,
            username: this.form.username,
            email: this.form.email,
            password: this.form.password,
            phone: this.form.phone,
            address: this.form.address,
            address2: this.form.address2,
            address3: this.form.address3,
            city: this.form.city,
            county: this.form.county,
            postcode: this.form.postcode,
            dob: this.form.dob,
            country_id: this.form.country_id,
            hear_about_us_platform_id: this.form.hear_about_us_platform_id,
            ic: this.$route.query.token,
          })
          .then((payload) => {
            swal
              .fire({
                text: 'Your account has been registered successfully. Please verify your email address to before continuing (it may be in your spam/junk folder.)',
                type: 'success',
                title: 'Success',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
              })
              .then(() => {
                this.$router.push({ name: 'login' })
              })
          })
      } catch (e) {
        const errors = e.response.data.errors.errors
        if (Object.keys(errors).length) {
          swal.fire({
            html: Object.values(errors).join('<br>'),
            type: 'error',
            title: 'Error',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
        }
      }
    },
    toggleShowConfirmPassword() {
      this.confirmPasswordVisible = !this.confirmPasswordVisible;
      if (this.confirmPasswordVisible) {
        this.confirmPasswordType = 'text';
      } else {
        this.confirmPasswordType = 'password';
      }
    },
    toggleShowPassword() {
      this.passwordVisible = !this.passwordVisible;
      if (this.passwordVisible) {
        this.passwordType = 'text';
      } else {
        this.passwordType = 'password';
      }
    },
  },
  head() {
    return { title: this.$t('register') }
  },
}
</script>
<style scoped lang="scss">
.center-svg {
  svg {
    margin: 0 auto;
  }
}
.disabled {
  background-color: lightgrey;
  cursor: default;
}
</style>
