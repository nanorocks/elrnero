import InatractorsTwo from '@/components/aboutCourses/instractors/InatractorsTwo'
import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'
import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'
import React from 'react'

export const metadata = {
  title: 'Instractors-list-2 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page() {
  return (
    <div className="main-content  ">
      <Header />
      <Preloader />
      <div className="content-wrapper  js-content-wrapper overflow-hidden">
        <PageLinks />
        <InatractorsTwo />
        <FooterOne />
      </div>
    </div>
  )
}
