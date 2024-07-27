




import ModeChanger from '@/components/homes/ModeChanger'
import HomeNine from '@/components/homes/homepageWrappers/HomeNine'
import React from 'react'
export const metadata = {
  title: 'Home-10 || Elrnero - Udemy base e-learning platform powered by Symfony PHP & React',
  description:
    'Elevate your e-learning content with Elrnero, the most impressive e-learning platform in the market.',

}
export default function page() {
  return (
    <div>
      <ModeChanger />
      <HomeNine />
    </div>
  )
}
