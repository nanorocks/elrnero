




import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'
import CourseDetailsOne from '@/components/courseSingle/CourseDetailsOne'
import CourseSlider from '@/components/courseSingle/CourseSlider'
import FooterOne from '@/components/layout/footers/FooterOne'

import Header from '@/components/layout/headers/Header'
import React from 'react'

export const metadata = {
  title: 'Couese-single-1 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page({ params }) {
  <Preloader />
  return (
    <div className="main-content  ">
      <Header />
      <div className="content-wrapper  js-content-wrapper ">
        <PageLinks />
        <CourseDetailsOne id={params.id} />
        <CourseSlider />
        <FooterOne />
      </div>


    </div>
  )
}
