import React, {useEffect, useState} from "react"
import FeatureCard from "./FeatureCard"
import { IoGolfOutline } from "react-icons/io5";
import { CiDiscount1 } from "react-icons/ci";
import { RiSecurePaymentLine } from "react-icons/ri";
import { IoQrCodeOutline } from "react-icons/io5";
import { MdOutlinePlace } from "react-icons/md";
import { RiRefund2Fill } from "react-icons/ri";
import { MdOutlineSupportAgent } from "react-icons/md";



export default function Feature(){
  return(
    <div id="#features" className="md:my-[6rem] h-full w-full flex flex-col items-center text-center gap-5 p-3">
        <p className="text-purple-600 text-xl font-semibold">
          Our Membership's Core Features
        </p>
        <h1 className="font-bold md:text-6xl text-2xl">Membership's Features</h1>
        <p className="md:w-[50%] w-full text-gray-500 font-semibold text-xl">
          There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form.
        </p>

        <div className="grid md:grid-cols-3 grid-cols-1 gap-5">
          <FeatureCard icon={<IoGolfOutline />} />
          <FeatureCard icon={<CiDiscount1  />} />
          <FeatureCard icon={<RiSecurePaymentLine />} />
          <FeatureCard icon={<MdOutlinePlace  />} />
          <FeatureCard icon={<RiRefund2Fill />} />
          <FeatureCard icon={<MdOutlineSupportAgent />} />

        </div>
    </div>
  )
}
