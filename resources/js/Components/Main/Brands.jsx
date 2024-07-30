import React from 'react'
import br1 from '../../Assets/Images/uideck.svg'
import br2 from '../../Assets/Images/tailgrids.svg'
import br3 from '../../Assets/Images/lineicons.svg'
import br4 from '../../Assets/Images/plainadmin.svg'
import br5 from '../../Assets/Images/ayroui.svg';



function Brands() {
  return (
    <div className="my-7 w-full border-b-2 border-t-2
        md:p-[3rem] p-[2rem] md:m-5 md:flex flex flex-wrap items-center
        justify-center gap-5"
    >
        <img className="" src={br1} alt="" />
        <img src={br5} alt="" />
        <img src={br2} alt="" />
        <img src={br3} alt="" />
        <img src={br4} alt="" />
        
    </div>
  )
}

export default Brands
