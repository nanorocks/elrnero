







import Faq from '@/components/common/Faq'
import Preloader from '@/components/common/Preloader'

import ContactTwo from '@/components/contacts/ContactTwo'

import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'
import React from 'react'
export const metadata = {
  title: 'Contact-2 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page() {
  return (
    <div className="main-content  ">
      <Preloader />

      <Header />
      <div className="content-wrapper js-content-wrapper overflow-hidden">


        <ContactTwo />
        <Faq />



        <FooterOne />
      </div>

    </div>
  )
}

