


import JoinToday from '@/components/aboutCourses/become/JoinToday'
import PageHeading from '@/components/aboutCourses/become/PageHeading'
import Tabs from '@/components/aboutCourses/become/Tabs'
import Instructors from '@/components/common/Instructors'
import LearningCommon from '@/components/common/LearningCommon'

import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'
import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'

import React from 'react'

export const metadata = {
  title: 'Instractors-become || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page() {
  return (
    <div className="main-content  ">
      <Preloader />
      <Header />
      <div className="content-wrapper  js-content-wrapper overflow-hidden">
        <PageLinks />
        <PageHeading />
        <section className=" layout-pb-lg">
          <div className="container">
            <Tabs />
            <LearningCommon />

          </div>
        </section>

        <JoinToday />

        <Instructors />


        <FooterOne />


      </div>
    </div>
  )
}
