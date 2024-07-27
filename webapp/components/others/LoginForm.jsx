"use client";

import Link from "next/link";
import React, { useState } from "react";

export default function LoginForm() {

  const handleSubmit = async (e) => {
    e.preventDefault();

    const email = e.target[0].value;
    const password = e.target[1].value;

    const myHeaders = new Headers();
    myHeaders.append("Accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const res = await fetch('http://app.localhost/api/login', {
      headers: myHeaders,
      method: "POST",
      body: JSON.stringify({
        'username': email,
        'password': password
      })
    })

    if (res.ok) {
      localStorage.setItem('token', JSON.stringify(await res.json()))
    }
    console.log(res);
  };
  return (
    <div className="form-page__content lg:py-50">
      <div className="container">
        <div className="row justify-center items-center">
          <div className="col-xl-6 col-lg-8">
            <div className="px-50 py-50 md:px-25 md:py-25 bg-white shadow-1 rounded-16">
              <h3 className="text-30 lh-13">Login</h3>
              <p className="mt-10">
                Don't have an account yet?
                <Link href="/signup" className="text-purple-1 ms-1">
                  Register for free
                </Link>
              </p>

              <form
                className="contact-form respondForm__form row y-gap-20 pt-30"
                onSubmit={(e) => handleSubmit(e)}
              >
                <div className="col-12">
                  <label className="text-16 lh-1 fw-500 text-dark-1 mb-10">
                    Email
                  </label>
                  <input required type="text" name="title" placeholder="Name" />
                </div>
                <div className="col-12">
                  <label className="text-16 lh-1 fw-500 text-dark-1 mb-10">
                    Password
                  </label>
                  <input
                    required
                    type="password"
                    name="title"
                    placeholder="Password"
                    autoComplete="current-password"
                  />
                </div>
                <div className="col-12">
                  <button
                    type="submit"
                    name="submit"
                    id="submit"
                    className="button -md -green-1 text-dark-1 fw-500 w-1/1"
                  >
                    Login
                  </button>
                </div>
              </form>


            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
