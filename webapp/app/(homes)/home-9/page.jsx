


import ModeChanger from '@/components/homes/ModeChanger'
import HomeNine from '@/components/homes/homepageWrappers/HomeNine'
import React from 'react'

export const metadata = {
  title: 'Home-9 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}

export default function page() {
  return (
    <div style={{ maxWidth: '100vw', overflow: 'hidden' }}>

      <ModeChanger whiteMode={true} />
      <HomeNine />
    </div>
  )
}
