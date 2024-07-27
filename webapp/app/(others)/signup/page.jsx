








import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'

import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'
import HeaderAuth from '@/components/layout/headers/HeaderAuth'
import AuthImageMove from '@/components/others/AuthImageMove'
import LoginForm from '@/components/others/LoginForm'
import SignUpForm from '@/components/others/SignUpForm'
import Terms from '@/components/terms/Terms'
import React from 'react'
export const metadata = {
  title: 'Register || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}
export default function page() {
  return (
    <div className="main-content  ">
      <Preloader />

      <HeaderAuth />
      <div className="content-wrapper js-content-wrapper overflow-hidden">
        <section className="form-page js-mouse-move-container">
          <AuthImageMove />
          <SignUpForm />
        </section>



      </div>

    </div>
  )
}
