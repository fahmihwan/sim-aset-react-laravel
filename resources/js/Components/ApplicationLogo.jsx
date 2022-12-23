
// import img from 'public/logo/mts.jpg'
import img from './../../../public/logo/mts.png'
export default function ApplicationLogo({ className }) {
    console.log(img)
    return (
        <div className="">
            <img src={img} className="w-32"/>
        </div>
    );
}
