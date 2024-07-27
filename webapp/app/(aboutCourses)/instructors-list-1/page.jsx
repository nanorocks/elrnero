



import Instractors from '@/components/aboutCourses/instractors/Instractors'
import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'

import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'

import React from 'react'

export const metadata = {
  title: 'Instractors-list-1 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page() {
  return (

    <main className="main-content">
      <Preloader />
      <Header />
      <div className="content-wrapper  js-content-wrapper overflow-hidden">


        <PageLinks />

        <Instractors />




        <FooterOne />


      </div>

    </main>

  )
}
