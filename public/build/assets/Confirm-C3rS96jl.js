import{r as t,j as e}from"./app-zK2m7Xr4.js";function a({error:l}){const[r,n]=t.useState(3);return t.useEffect(()=>{const s=setInterval(()=>{n(o=>o-1)},1e3),i=setTimeout(()=>{window.location.href="/"},3e3);return()=>{clearInterval(s),clearTimeout(i)}},[]),e.jsx("div",{className:"container mx-auto h-full w-full",children:e.jsx("div",{className:"flex flex-col items-center justify-center gap-5",children:e.jsxs("div",{className:"w-[35%] bg-white p-[5rem] my-[12rem]",children:[e.jsx("h2",{className:"text-4xl text-center font-bold",children:"SUCCESS"}),e.jsx("p",{className:"text-center text-green-400 font-bold text-lg my-5",children:"Your registration is now pending. Soon admin will approve your request"}),e.jsxs("a",{className:`text-center bg-blue-600 p-2 my-5\r
             flex items-center justify-center text-white font-bold`,children:["Redirecting in ",r]})]})})})}export{a as default};
