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
    <div id="feature" className="md:my-[6rem] h-full w-full flex
      flex-col items-center text-center gap-5 p-3">
        <p className="text-purple-600 text-xl font-semibold">
          Our Membership's Core Features
        </p>
        <h1 className="font-bold md:text-6xl text-2xl">Membership's Features</h1>
        <p className="md:w-[50%] w-full text-gray-500 font-semibold text-xl">
          There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form.
        </p>

        <div className="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-5">
          <FeatureCard 
            icon={<IoGolfOutline />}
            title="Golf Access"
            desc={"Full time golf access. With pro players and guides. 24/7 support"}
          />
          <FeatureCard
            icon={<CiDiscount1  />}
            title={"Swimming Access"}
            desc={"Full time swimming support. Life support guaranteed. Spa and massage available"}
          />
          <FeatureCard
            icon={<RiSecurePaymentLine />}
            title={"Secure Payment"}
            desc={"Digital payment system just swipe your QR and you are ready to roll."}
          />
          <FeatureCard
            icon={<MdOutlinePlace  />}
            title={"Reporting and Analytics"}
            desc={"Gain insights into membership trends, financials, and engagement with customizable reports and dashboards. "}
          />
          <FeatureCard
            icon={<RiRefund2Fill />}
            title={"Access Control"}
            desc={"Manage access to members-only content, events, and resources with robust access control settings."}
          />
          <FeatureCard
            icon={<MdOutlineSupportAgent />}
            title={"Self-Service Member Portal"}
            desc={"Empower members to update their profiles, renew memberships, and register for events through a user-friendly portal."}
          />

        </div>
    </div>
  )
}
