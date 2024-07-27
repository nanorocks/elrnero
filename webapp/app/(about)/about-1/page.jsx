




import About from '@/components/about/About'


import Brands from '@/components/common/Brands'
import Instructors from '@/components/common/Instructors'
import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'
import TestimonialsOne from '@/components/common/TestimonialsOne'
import WhyCourse from '@/components/homes/WhyCourse'


import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'
import React from 'react'

export const metadata = {
  title: 'About-1 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page() {
  return (
    <div className="main-content  ">
      <Preloader />

      <Header />
      <div className="content-wrapper js-content-wrapper overflow-hidden">
        <PageLinks />
        <About />
        <WhyCourse />


        <TestimonialsOne />
        <Instructors />
        <Brands />




        <FooterOne />
      </div>

    </div>
  )
}

