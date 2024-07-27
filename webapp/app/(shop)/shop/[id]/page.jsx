






import PageLinks from '@/components/common/PageLinks'
import Preloader from '@/components/common/Preloader'



import FooterOne from '@/components/layout/footers/FooterOne'
import Header from '@/components/layout/headers/Header'
import ProductDetails from '@/components/shop/ProductDetails'
import RelatedProducts from '@/components/shop/RelatedProducts'
import React from 'react'
export const metadata = {
  title: 'Shop-details || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}
export default function page({ params }) {
  return (
    <div className="main-content  ">
      <Preloader />

      <Header />
      <div className="content-wrapper js-content-wrapper overflow-hidden">
        <PageLinks />

        <ProductDetails id={params.id} />
        <RelatedProducts />



        <FooterOne />
      </div>

    </div>
  )
}
